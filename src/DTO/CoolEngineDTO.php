<?php

namespace CoolView\DTO;

trait CoolEngineDTO {

    private string $viewsPath;
    private string $cachePath;

    private array $sections = [];
    private array $sectionStack = [];

    private string $layout = '';

}