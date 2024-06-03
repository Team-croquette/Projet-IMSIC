<?php 

class IndexAdminController extends AdminControllerCore{
    protected string $name;

    public function __construct()
    {
        $this->template = 'index.php';
    }

    public function run(): bool
    {
        if (!key_exists('token',$_SESSION)){
            header('Location: ./login/');
            die;
        }
        if( $_SESSION['token'] != (new LoginAdminController())->getToken($_SESSION['login'])) {
            header('Location: ./login/');
            die;
        }
        $this->renderTemplate($this->getTemplateVariables());
        return true;
    } 

    private function getTemplateVariables():array{
        
        $owner = (new UserModel())->isOwner($_SESSION['login']);
        $vars = [
            'title' => 'Espace administrateur',
            'owner' => $owner,
        ];

        if ($owner) {
            $vars['adminUsers'] =  (new UserModel())->getAllUser();
            $vars['addUserForm'] =  $this->getUserForm();
        }
        $vars['questions'] =  (new QuestionModel())->getAllQuestion();
        $vars['addQuestionForm'] =  $this->getQuestionForm();

        $vars['userErrors'] = [];
        if (isset($_SESSION['userErrors']) && json_decode($_SESSION['userErrors']) != []) {
            $vars['userErrors'] = json_decode($_SESSION['userErrors']);
            unset($_SESSION['userErrors']);
        }
        $vars['questionErrors'] = [];
        if (isset($_SESSION['questionErrors']) && json_decode($_SESSION['questionErrors']) != []) {
            $vars['questionErrors'] = json_decode($_SESSION['questionErrors']);
            unset($_SESSION['questionErrors']);
        }
       
        return $vars ;
    }

    private function getQuestionForm():string{
        $formBuilder = new FormBuilder();
        $formBuilder
            ->setAction('./question/index.php')
            ->setMethod('POST')
            ->setClass('form')
            ->add('question','Intitulé de la question', InputTypeEnum::GROUP,false,'', [
                'class' => 'question_group', 
                'children' => [
                    new FormInput('libelle','', InputTypeEnum::TEXTAREA,false),
                    new FormInput('image[0]','Ajouter des images à la question', InputTypeEnum::IMAGE,false),
                    new FormInput('imageDescription[0]','Description de l’image <small>(facultatif)</small>', InputTypeEnum::TEXTAREA,false),
                    new FormInput('image[1]','', InputTypeEnum::IMAGE,false),
                    new FormInput('imageDescription[1]','Description de l’image <small>(facultatif)</small>', InputTypeEnum::TEXTAREA,false),
                ]
            ])
            ->add('reponse','Réponses autorisées :', InputTypeEnum::GROUP,false,'', [
                'class' => 'reponse_group',
                'children' => [
                    new FormInput('questionType','Texte libre', InputTypeEnum::RADIO,false,QuestionTypeEnum::FREE_TEXT->value, ['id' => QuestionTypeEnum::FREE_TEXT->value]),
                    new FormInput('questionType','Slider', InputTypeEnum::RADIO,false, QuestionTypeEnum::SLIDER->value, ['id' => QuestionTypeEnum::SLIDER->value]),
                    new FormInput('slider','Max :', InputTypeEnum::NUMBER,false, '', ['id' => 'text']),
                    new FormInput('questionType','Réponse sous forme d’images :', InputTypeEnum::RADIO,false, QuestionTypeEnum::MULTI_IMAGE->value, ['id' => QuestionTypeEnum::MULTI_IMAGE->value]),
                    new FormInput('imageResp[0]','', InputTypeEnum::IMAGE,false),
                    new FormInput('imageRespDesc[0]','', InputTypeEnum::TEXT,false, '', ['placeholder' => 'Description de l’image']),
                    new FormInput('imageResp[1]','', InputTypeEnum::IMAGE,false),
                    new FormInput('imageRespDesc[1]','', InputTypeEnum::TEXT,false, '', ['placeholder' => 'Description de l’image']),
                    new FormInput('imageResp[2]','', InputTypeEnum::IMAGE,false),
                    new FormInput('imageRespDesc[2]','', InputTypeEnum::TEXT,false, '', ['placeholder' => 'Description de l’image']),
                    new FormInput('imageResp[3]','', InputTypeEnum::IMAGE,false),
                    new FormInput('imageRespDesc[3]','', InputTypeEnum::TEXT,false, '', ['placeholder' => 'Description de l’image']),
                    new FormInput('questionType','Réponse sous forme de texte à choisir :', InputTypeEnum::RADIO ,false, QuestionTypeEnum::TEXT_CHOICE->value, ['id' => QuestionTypeEnum::TEXT_CHOICE->value]),
                    new FormInput('choiseText[0]','', InputTypeEnum::TEXT,false, '', ['placeholder' => 'Ecrire la réponse à choisir ici']),
                    new FormInput('choiseText[1]','', InputTypeEnum::TEXT,false, '', ['placeholder' => 'Ecrire la réponse à choisir ici']),
                    new FormInput('choiseText[2]','', InputTypeEnum::TEXT,false, '', ['placeholder' => 'Ecrire la réponse à choisir ici']),
                    new FormInput('choiseText[3]','', InputTypeEnum::TEXT,false, '', ['placeholder' => 'Ecrire la réponse à choisir ici']),
                ]
            ])
            ->add('action','', InputTypeEnum::HIDDEN,true,'add')
            ->add('submit','', InputTypeEnum::SUBMIT,true,'Ajouter');

        return $formBuilder->renderForm();
    }
    
    private function getUserForm():string
    {
        $formBuilder = new FormBuilder();
        $formBuilder
            ->setAction('./user/index.php')
            ->setMethod('GET')
            ->setClass('form')
            ->add('login','Identifiant', InputTypeEnum::TEXT,true)
            ->add('password','Mot de passe', InputTypeEnum::PASSWORD,true,'', ['pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$'])
            ->add('confirm_password','Confirmation mot de passe', InputTypeEnum::PASSWORD,true,'', ['pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$'])
            ->add('action','', InputTypeEnum::HIDDEN,true,'add')
            ->add('submit','', InputTypeEnum::SUBMIT,true,'Ajouter');

        return $formBuilder->renderForm();
    }
}
