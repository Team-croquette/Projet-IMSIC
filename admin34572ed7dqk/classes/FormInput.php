<?php 

$basePath = explode('admin34572ed7dqk',dirname(__FILE__))[0];

require_once $basePath .'/admin34572ed7dqk/enum/InputType.php';

class FormInput{

    public function __construct(   
        private string $name,
        private string $label,
        private InputTypeEnum $type,
        private bool $required,
        private string $defaultValue = '',
        private array $extra = [],
    )
    {
        
        if ($type == InputTypeEnum::ENUM) {
            $this->extra['options'] = $extra['enum']::cases;
        }

        if (in_array($this->type, [InputTypeEnum::SELECT, InputTypeEnum::ENUM]) && !key_exists('options', $this->extra) ) {
            $this->extra['options'] = ['Aucune option renseignée' => 'error'];
        }
        if ($this->type == InputTypeEnum::GROUP && !key_exists('children', $this->extra)) {
            $this->extra['error'] = ['Aucune option renseignée' => 'error'];
        }
    }

    public function renderInput():string
    {
        $prefix = '';
        $innerHtml = '';
        $suffix = '>';
        $label = '';
        $for = $this->name;

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
                $prefix = '<input type="file" accept="image/*" ';
                break;
            case InputTypeEnum::GROUP :
                $prefix = '<div ';
                $innerHtml = '>';
                foreach ($this->extra['children'] as $input) {
                    $innerHtml .= $input->renderInput();
                }
                $suffix = '</div>';
                break;
            case InputTypeEnum::TEXTAREA :
                $prefix = '<textarea ';
                $innerHtml = '>' . $this->defaultValue;
                $suffix = '</textarea>';
                break;
            case InputTypeEnum::RADIO :
                $for = isset($this->extra['id']) ? $this->extra['id'] : $this->name;
            default:
                $prefix = '<input type="'.$this->type->value.'"';
                break;
        
        }
        
        if ($this->label != '') {
            $label = '<label for="'. $for .'" class="admin-form_label">'.$this->label.'</label>';
        }
        $attributes = '';
        foreach($this->extra as $attribute => $attrValue){
            if ($attribute != 'options' && !is_array($attrValue)) {
                $attributes .= ' ' . $attribute . '="' . $attrValue . '"';
            }
        }
        if ($this->required) {
            $attributes .= ' required="required"';
        }

        $value = isset($_POST[$this->name]) ? $_POST[$this->name] : $this->defaultValue;
        $html = '<div class="admin-form_group">'.$label . $prefix . 'name="'.$this->name.'"' . ' value="'.$value.'"' . $attributes . $innerHtml . $suffix.'</div>';

        return $html;
    }
}
