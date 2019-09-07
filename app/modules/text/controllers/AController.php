<?php
namespace app\modules\nextadmin\modules\text\controllers;
use app\modules\nextadmin\components\Lang;
use app\modules\nextadmin\modules\text\models\TextTranslation;
use Uni;
use uni\data\ActiveDataProvider;
use uni\widgets\ActiveForm;

use app\modules\nextadmin\components\Controller;
use app\modules\nextadmin\modules\text\models\Text;

class AController extends Controller
{
    public $rootActions = ['create', 'delete'];

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => Text::find(),
        ]);
        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate($slug = null)
    {
        $model = new Text;
        if ($model->load(Uni::$app->request->post())) {
            if(Uni::$app->request->isAjax){
                Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if($model->save()){
                    if(isset($_POST['lang'])&&isset($_POST['trans-text'])){
                        $trans=new TextTranslation();
                        $trans->text_id=$model->text_id;
                        $trans->language=$_POST['lang'];
                        $trans->text=$_POST['trans-text'];
                        if($trans->save()){
                            if($trans->language==Lang::getCurrent()->url){
                                $model->text=$trans->text;
                                $model->save();
                            }
                        };
                    }
                    $this->flash('success', Uni::t('app', 'Text created'));
                    return $this->redirect(['/admin/'.$this->module->id]);
                }
                else{
                    $this->flash('error', Uni::t('app', 'Create error. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        }
        else {
            if($slug){
                $model->slug = $slug;
            }
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    public function actionEdit($id)
    {
        $model = Text::findOne($id);

        if($model === null){
            $this->flash('error', Uni::t('app', 'Not found'));
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        if ($model->load(Uni::$app->request->post())) {
            if(Uni::$app->request->isAjax){
                Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if(isset($_POST['lang'])&&$_POST['lang']==Lang::getDefaultLang()->url){
                    if(!$model->save()){
                        $this->flash('error', Uni::t('app', 'Update error. {0}', $model->formatErrors()));
                    }
                }
                if(isset($_POST['lang'])) {
                    $trans = new TextTranslation();
                    $temp=TextTranslation::find()->where(['language'=>$_POST['lang'],'text_id'=>$model->text_id])->one();
                    if($temp)$trans=$temp;
                    $trans->text_id = $id;
                    $trans->language = $_POST['lang'];
                    $trans->text = $model->text;
                    if($trans->save()){
                        $this->flash('success', Uni::t('app', 'Text updated'));
                    }else{
                        $this->flash('error', Uni::t('app', 'Update error. {0}', $trans->formatErrors()));
                    }
                }
                $this->flash('success', Uni::t('app', 'Text updated'));

                return $this->refresh();
            }
        }
        else {
            return $this->render('edit', [
                'model' => $model
            ]);
        }
    }

    public function actionDelete($id)
    {
        if(($model = Text::findOne($id))){
            $model->delete();
        } else {
            $this->error = Uni::t('app', 'Not found');
        }
        return $this->formatResponse(Uni::t('app', 'Text deleted'));
    }
    public function actionGetranslation(){
        $def=Lang::getDefaultLang()->url;
        if(Uni::$app->request->isAjax){
            $textblock=$_POST["block"];
            $language=$_POST["language"];
            $trans=TextTranslation::find()->where(["language"=>$language,'text_id'=>$textblock])->asArray()->one();
            if($trans)return json_encode($trans);else{
                if($language==$def){
                    $text=Text::findOne(["text_id"=>$textblock]);
                    if($text){
                        $trans=new TextTranslation();
                        $trans->text=$text->text;
                        $trans->text_id=$text->text_id;
                        $trans->language=$language;
                        if($trans->save()){
                            $trans_n=TextTranslation::find()->where(["id"=>$trans->id])->one();
                            return json_encode($trans_n);
                        }else{
                            var_dump($trans);
                        }
                    }
                }else{
                }
            }
        }
    }
}