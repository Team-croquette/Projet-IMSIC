<?php

enum QuestionTypeEnum: string{
    case FREE_TEXT = 'freeText';
    case SLIDER = 'slider';
    case MULTI_IMAGE = 'multiImage';
    case TEXT_CHOICE = 'textChoice';
}
