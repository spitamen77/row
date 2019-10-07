<?
// use Yii;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Profil';
// $this->params['breadcrumbs'][] = $this->title;


// if (!Yii::$app->user->isGuest) {
// 	echo Yii::$app->user->identity->username;
// 	// echo '<pre>'; var_dump(Yii::$app->user->identity); die;
// }
?>
<div style="width: 50%" class="menu-view">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= DetailView::widget([
        'model' => Yii::$app->user->identity,
        'attributes' => [
//             'id',
        [
            'attribute'=>'image',
            'label'=>'Rasmi:',
            'format'=>'raw',
            'value'=>function($model){
//                return Html::img($model->image,['style'=>'width:100%']);
                return '<img width="100px" src="/web/'.$model->image.'">';
         }
        ],
//        'username',
        [
            'attribute'=>'username',
            'label'=>'Foydalanuvchi:'
        ],
        'fio',
        
        // 'birthdate',
        [
                'attribute'=>'birthdate',
                'value'=>function($model){
                    return date('d-m-Y', $model->birthdate);
                }
            ],
        'tel',
        'email',
      
            // 'title',
            // 'slug',
            // 'template_id',
            // 'tree',
            // 'child',
            // 'status',
            // 'user_id',   
            // 'updated_date',
        ],
    ]) ?>
    <p>
        <?= Html::a('Update', ['uzgariw'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Parol', ['parol'], ['class' => 'btn btn-primary']) ?>
        <a href='javascript:history.back()' class='btn btn-danger'>ortga</a>

    </p>

</div>
