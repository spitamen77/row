<?
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;

$m = new \app\models\Feedback();
$this->registerJs('Muxr.addFeedback();');
?>
<!-- content start-->

        <div class="row page-bar">
            <div class="container">
                 <div class="comments-form-holder">
                                <div id="comments">

                                    <div id="respond" class="comment-respond">
                                        <h3 id="reply-title" class="comment-reply-title"></h3>
                                        <h2 id="reply-title">Xabar yuborish</h2>
                                        <small><a rel="nofollow" id="cancel-comment-reply-link"
                                                  href="#" style="display:none;">Cancel
                                                reply</a></small>

                                        <? /*=($success == true) ? "Succeesfull" : ""*/ ?>
                                        <!--- Modal New Direction Add -->

                                        <?php $form = Form::begin(['method' => 'post', 'action' => '/page/video/save', 'id' => 'commentform', 'class' => 'comment-form']); ?>
                                        <div class="uk-form-row">
                                            <?= $form->field($m, 'name')->textInput(['tabindex' => 1, 'id' => 'name']) ?>
                                        </div>
                                        <div class="uk-form-row">
                                            <?= $form->field($m, 'email')->textInput(['tabindex' => 2, 'id' => 'email']) ?>
                                        </div>
                                        <div class="uk-form-row">
                                            <?= $form->field($m, 'subject')->textInput(['tabindex' => 3, 'id' => 'subject']) ?>
                                        </div>
                                        <div class="uk-form-row">
                                            <?= $form->field($m, 'text')->textarea(['tabindex' => 4, 'rows' => 8, 'id' => 'text']) ?>
                                        </div>
                                        <br/>
                                        <?= Html::button(Uni::t('app', 'Send Message'), ['type' => 'button', 'tabindex' => 5, 'id' => 'submit', 'class' => 'md-btn md-btn-primary md-btn-block']) ?>
                                        <?php Form::end(); ?>


                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                   