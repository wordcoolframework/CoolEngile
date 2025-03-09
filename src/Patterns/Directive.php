<?php

namespace CoolView\Patterns;

use CoolView\CSRFService\CSRFService;

trait Directive {

    public static function get() : array {

        return [
            // Variables
            'variable' => function ($match) {
                return "<?php echo htmlspecialchars({$match}, ENT_QUOTES, 'UTF-8'); ?>";
            },

            'csrf' => function () {
                return "<input 
                type='hidden' 
                name='_token' 
                value=\"" . htmlspecialchars(CSRFService::getToken(),
                        ENT_QUOTES,
                        'UTF-8'
                    ) . "\"
                >";
            },

            // Asset
            'asset' => function ($match) {
                return "<?php echo \$this->asset({$match}); ?>";
            },

            // Conditional statements
            'if' => function ($match) {
                return "<?php if ({$match}): ?>";
            },
            'elseif' => function ($match) {
                return "<?php elseif ({$match}): ?>";
            },
            'else' => function () {
                return "<?php else: ?>";
            },
            'endif' => function () {
                return "<?php endif; ?>";
            },

            // Loops
            'foreach' => function ($match) {
                return "<?php foreach ({$match}): ?>";
            },
            'endforeach' => function () {
                return "<?php endforeach; ?>";
            },
            'for' => function ($match) {
                return "<?php for ({$match}): ?>";
            },
            'endfor' => function () {
                return "<?php endfor; ?>";
            },
            'while' => function ($match) {
                return "<?php while ({$match}): ?>";
            },
            'endwhile' => function () {
                return "<?php endwhile; ?>";
            },

            // Sections
            'section' => function ($match) {
                return "<?php \$this->startSection({$match}); ?>";
            },
            'endsection' => function () {
                return "<?php \$this->endSection(); ?>";
            },
            'yield' => function ($match) {
                return "<?php echo \$this->yieldSection({$match}); ?>";
            },

            // Extends
            'extends' => function ($match) {
                return "<?php \$this->extend({$match}); ?>";
            },

            // @is directives
            'istrue' => function ($match) {
                return "<?php if (!empty({$match}) && {$match} === true): ?>";
            },
            'isfalse' => function ($match) {
                return "<?php if (!empty({$match}) && {$match} !== true): ?>";
            },
            'isnull' => function ($match) {
                return "<?php if (is_null({$match})): ?>";
            },
            'isnotnull' => function ($match) {
                return "<?php if (!is_null({$match})): ?>";
            },

            'date' => function ($match) {
                return "<?php echo date('Y-m-d', strtotime({$match})); ?>";
            },
            'isset' => function ($match) {
                return "<?php if (isset({$match})): ?>";
            },
            'endisset' => function () {
                return "<?php endif; ?>";
            },
            'empty' => function ($match) {
                return "<?php if (empty({$match})): ?>";
            },
            'endempty' => function () {
                return "<?php endif; ?>";
            },
            'break' => function () {
                return "<?php break; ?>";
            },
            'continue' => function () {
                return "<?php continue; ?>";
            },
            'repeat' => function ($match) {
                $arguments = explode(',', $match);
                $string = trim($arguments[0] ?? "''");
                $times = trim($arguments[1] ?? '1');

                return "<?php echo str_repeat({$string}, {$times}); ?>";
            },
            'link' => function ($match) {
                return "<?php echo '<a href=\"' . htmlspecialchars({$match}, ENT_QUOTES, 'UTF-8') . '\">' . htmlspecialchars({$match}, ENT_QUOTES, 'UTF-8') . '</a>'; ?>";
            },
            'dd' => function($match){
                return "<?php dd({$match}) ?>";
            },
            'concat' => function ($match) {
                return "<?php echo implode('', {$match}); ?>";
            },
            'default' => function ($match) {
                return "<?php echo !empty({$match}[0]) ? {$match}[0] : {$match}[1]; ?>";
            },
            'isgreater' => function ($match) {
                return "<?php if ({$match}[0] > {$match}[1]): ?>";
            },
            'isless' => function ($match) {
                return "<?php if ({$match}[0] < {$match}[1]): ?>";
            },
            'endisgreater' => function () {
                return "<?php endif; ?>";
            },
            'endisless' => function () {
                return "<?php endif; ?>";
            },
            'fileexists' => function ($match) {
                return "<?php if (file_exists({$match})): ?>";
            },
            'endfileexists' => function () {
                return "<?php endif; ?>";
            },

            'inject' => function ($match) {
                $arguments  = explode(',', $match);
                $variable   = trim($arguments[0] ?? "''", "' ");
                $namespace  = trim($arguments[1] ?? "''", "' ");

                return "<?php \${$variable} = new {$namespace}(); ?>";
            },



            'wc:if' => function ($match) {
                return "<?php if ({$match}): ?>";
            },
            'wc:else' => function () {
                return "<?php else: ?>";
            },
            'wc:endif' => function () {
                return "<?php endif; ?>";
            },

            'wc:foreach' => function ($match) {
                return "<?php foreach ({$match}): ?>";
            },
            'wc:endforeach' => function () {
                return "<?php endforeach; ?>";
            },

            'wc:istrue' => function ($match) {
                return "<?php if (!empty({$match}) && {$match} === true): ?>";
            },

            'wc:isfalse' => function ($match) {
                return "<?php if (!empty({$match}) && {$match} !== true): ?>";
            },

            'wc:isnull' => function ($match) {
                return "<?php if (is_null({$match})): ?>";
            },

            'wc:isnotnull' => function ($match) {
                return "<?php if (!is_null({$match})): ?>";
            },

            'wc:isset' => function ($match) {
                return "<?php if (isset({$match})): ?>";
            },
            'wc:endisset' => function () {
                return "<?php endif; ?>";
            },

            'wc:empty' => function ($match) {
                return "<?php if (empty({$match})): ?>";
            },
            'endempty' => function () {
                return "<?php endif; ?>";
            },

            'wc:repeat' => function ($match) {
                $arguments = explode(',', $match);
                $string = trim($arguments[0] ?? "''");
                $times = trim($arguments[1] ?? '1');

                return "<?php echo str_repeat({$string}, {$times}); ?>";
            },

            'wc:link' => function ($match) {
                return "<?php echo '<a href=\"' . htmlspecialchars({$match}, ENT_QUOTES, 'UTF-8') . '\">' . htmlspecialchars({$match}, ENT_QUOTES, 'UTF-8') . '</a>'; ?>";
            },

            'wc:dd' => function($match){
                return "<?php dd({$match}) ?>";
            },

            'wc:concat' => function ($match) {
                return "<?php echo implode('', {$match}); ?>";
            },
            'wc:default' => function ($match) {
                return "<?php echo !empty({$match}[0]) ? {$match}[0] : {$match}[1]; ?>";
            },

            'wc:fileexists' => function ($match) {
                return "<?php if (file_exists({$match})): ?>";
            },
            'wc:endfileexists' => function () {
                return "<?php endif; ?>";
            },

            'wc:inject' => function ($match) {
                $arguments  = explode(',', $match);
                $variable   = trim($arguments[0] ?? "''", "' ");
                $namespace  = trim($arguments[1] ?? "''", "' ");

                return "<?php \${$variable} = new {$namespace}(); ?>";
            },

            // live cool
            'hx:get' => function ($match) {
                return "<div hx-get=\"" . htmlspecialchars($match, ENT_QUOTES, 'UTF-8') . "\" hx-trigger=\"click\">Click me</div>";
            },
        ];

    }

    public function getFilters(): array {
        return [
            'upper'     => 'strtoupper',  // تبدیل به حروف بزرگ
            'lower'     => 'strtolower',  // تبدیل به حروف کوچک
            'first'     => 'firstElement', // اولین عنصر آرایه
            'last'      => 'lastElement',   // آخرین عنصر آرایه
            'length'    => 'stringLength', // طول رشته
            'trim'      => 'trimString',    // حذف فاصله‌های اضافی در ابتدا و انتهای رشته
            'replace'   => 'replaceString',  // جایگزینی متن در رشته
            'join'      => 'joinArray',     // تبدیل آرایه به رشته با یک جداکننده
            'split'     => 'splitString',  // تقسیم رشته به آرایه
            'slug'      => 'generateSlug',  // تولید اسلاگ از رشته
            'abs'       => 'absValue', // مطلق یک عدد
            'capitalize'=> 'capitalizeString', // تبدیل اولین حرف به بزرگ
        ];
    }

}