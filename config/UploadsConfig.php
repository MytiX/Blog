<?php

namespace Config;

class UploadsConfig
{
    const IMAGE_PATH = "uploads/img/";
    const EXTENSION_ALLOWED = [
        'png',
        'jpg',
        'jpeg'
    ];
    const MIMETYPE_ALLOWED = [
        'image/png',
        'image/jpeg'
    ];
    const MAX_SIZE_IMAGE = 250000;
    const MIN_SIZE_IMAGE = 0;
}
