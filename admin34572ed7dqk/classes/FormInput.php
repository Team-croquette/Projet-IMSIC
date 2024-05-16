<?php 

$basePath = explode('admin34572ed7dqk',dirname(__FILE__))[0];

require_once $basePath .'/admin34572ed7dqk/enum/InputType.php';

class FormInput{

    public function __construct(   
        private string $name,
        private InputTypeEnum $type,
        private bool $required,
        private string $defaultValue = '',
        private array $extra = [],
    )
    {
        
        if ($type == InputTypeEnum::ENUM) {
            $extra['options'] = $extra['enum']::cases;
        }

        if (in_array($type, [InputTypeEnum::SELECT, InputTypeEnum::ENUM]) && !in_array('options', $extra) ) {
            $extra['options'] = ['Aucune option renseignée' => 'error'];
        }
    }

    public function renderInput():string
    {
        $prefix = '';
        $innerHtml = '';
        $suffix = '>';

        switch ($this->type) {         
            case InputTypeEnum::ENUM :
            case InputTypeEnum::SELECT :
                $prefix = '<select ';
                $innerHtml .= '>';
                foreach($this->extra['options'] as $name => $value){
                    $innerHtml .= '<option class="admin-form_option" value="'.$name.'">'.$value.'</option>';
                }
                $suffix = '</select>';
                break;
            
            case InputTypeEnum::IMAGE :
                # code...
            
            default:
                $prefix = '<input type="'.$this->type->value.'"';
                break;
        }
        $attributes = '';
        foreach($this->extra as $attribute => $attrValue){
            if ($attribute != 'options') {
                $attributes .= ' ' . $attribute . '="' . $attrValue . '"';
            }
        }
        if ($this->required) {
            $attributes .= ' required="required"';
        }

        $value = isset($_POST[$this->name]) ? $_POST[$this->name] : $this->defaultValue;
        $html = $prefix . 'name="'.$this->name.'"' . ' value="'.$value.'"' . $attributes . $innerHtml . $suffix;

        return $html;
    }
}
