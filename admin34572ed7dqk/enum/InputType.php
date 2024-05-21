<?php

enum InputTypeEnum: string{
    case TEXT = 'text';
    case IMAGE = 'fileupload';
    case SELECT = 'select';
    case ENUM = 'enum';
    case PASSWORD = 'password';
    case SUBMIT = 'submit';
}
