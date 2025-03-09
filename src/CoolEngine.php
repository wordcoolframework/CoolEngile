<?php

namespace CoolView;

use Configuration\Config;
use CoolView\DTO\CoolEngineDTO;
use CoolView\Patterns\Directive;

final class CoolEngine {

    use Directive, CoolEngineDTO;

    public function __construct(string $viewsPath, string $cachePath){
        $this->viewsPath = rtrim($viewsPath, '/');
        $this->cachePath = rtrim($cachePath, '/');
    }

    public function asset(string $path): string {
        return '/public/' . ltrim($path, '/');
    }

    public function render(string $view, array $data = []): string {

        $templateFile = $this->viewsPath . '/' . $view . '.cool.php';

        if (!file_exists($templateFile)) {
            throw new \RuntimeException("View file '{$view}' not found.");
        }

        $compiledFile = $this->cachePath . '/' . md5($view) . '.cool.php';

        if (!file_exists($compiledFile) || filemtime($templateFile) > filemtime($compiledFile)) {
            $this->compile($templateFile, $compiledFile);
        }

        extract($data, EXTR_SKIP);
        ob_start();
        include $compiledFile;
        return ob_get_clean();
    }

    private function compile(string $templateFile, string $compiledFile): void {
        $template = file_get_contents($templateFile);

        $compiledTemplate = $this->parseDirectives($template);

        file_put_contents($compiledFile, $compiledTemplate);
    }

    public function startSection(string $name): void {
        ob_start();
        $this->sectionStack[] = $name;
    }

    public function endSection(): void {

        if (empty($this->sectionStack)) {
            throw new \RuntimeException("You must start a section before ending it.");
        }

        $name = array_pop($this->sectionStack);
        $this->sections[$name] = ob_get_clean();
    }

    public function yieldSection(string $name): string {
        return $this->sections[$name] ?? '';
    }

    public function extend(string $layout): void {
        $this->layout = $layout;
    }

    public function clearCache(): void {
        array_map('unlink', glob($this->cachePath . '/*.php'));
    }

    private function parseDirectives(string $template): string {

        $directives = self::get();
        $filters = $this->getFilters();

        $PrefixCharCoolEngine = Config::get('cool-view.PrefixCharCoolEngine');

        $template = preg_replace_callback('/\{\{\s*(.+?)\s*\|\s*(\w+)\s*\}\}/', static function ($matches) use ($filters) {
            $variable = $matches[1] ?? '';
            $filter = $matches[2] ?? '';
            if (isset($filters[$filter])) {
                return "<?php echo {$filters[$filter]}({$variable}); ?>";
            }
            return $matches[0];
        }, $template);

        foreach ($directives as $key => $callback) {
            $pattern = $key === 'variable'
                ? '/\{\{\s*(.+?)\s*\}\}/'
                : "/{$PrefixCharCoolEngine}$key\\s*(?:\\((.+?)\\))?/";
            $template = preg_replace_callback($pattern, static function ($matches) use ($callback) {
                return $callback($matches[1] ?? null);
            }, $template);
        }

        foreach ($directives as $key => $callback) {
            $pattern = "/<$key(?: var=\"(.+?)\")?>/";
            $endPattern = "/<\/$key>/";

            $template = preg_replace_callback($pattern, static function ($matches) use ($callback) {
                return $callback($matches[1] ?? null);
            }, $template);

            $template = preg_replace_callback($endPattern, static function () use ($callback) {
                return $callback();
            }, $template);
        }

        return $template;
    }

    public function view(string $view, array $data): string {
        $content = $this->render($view, $data);

        if ($this->layout) {
            return $this->render($this->layout, array_merge($data, ['content' => $content]));
        }

        return $content;
    }
}