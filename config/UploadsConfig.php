<?php

namespace Config;

class UploadsConfig
{
    const IMAGE_PATH = "uploads/img/";
    const IMAGE_ALLOWED = [
        'png',
        'jpg',
        'jpeg'
    ];
    const MAX_SIZE_IMAGE = 250000;
    const MIN_SIZE_IMAGE = 0;
}
