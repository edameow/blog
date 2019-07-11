<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Черновик';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
        <h1 class="h1-to-h3"><?= Html::encode($this->title) ?></h1>
        <ul class="list-unstyled draft-list">
            <?php foreach ($model as $item) { ?>
                <?php Pjax::begin(['enablePushState' => false]);?>
                <li>
                    <article class="post post-list">
                        <div class="row">
                            <?php if ($item['image']) { ?>
                                <div class="col-sm-4">
                                    <div class="post-thumb">
                                        <?= Html::img("{$item->getImage()}")?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($item['image']) { ?>
                            <div class="col-sm-8">
                                <?php } else { ?>
                                <div class="col-sm-12" style="margin-left: 1em">
                                    <?php } ?>
                                    <div class="post-content">
                                        <header class="text-uppercase">
                                            <h6>
                                                <?= $item->category->title?>
                                            </h6>
                                            <h3>
                                                <?= $item['title']?>
                                            </h3>
                                        </header>
                                        <div class="entry-content">
                                            <p>
                                                <?php
                                                if (strlen($item['content']) <= 200) {
                                                    for ($i = 0; $i < strlen($item['content']); $i++) {
                                                        echo $item['content'][$i];
                                                    }
                                                } else {
                                                    for ($i = 0; $i <= 200; $i++) {
                                                        echo $item['content'][$i];
                                                    } echo '...';
                                                }?>
                                            </p>
                                        </div>
                                        <div class="btn-continue-reading text-uppercase" style="margin-bottom: 1em">
                                            <?= Html::a('Редактировать', Url::to(['profile/article', 'id' => $item['id']]), ['class' => 'btn btn-success'])?>
                                            <?= Html::a('Предложить', ['offer-article', 'id' => $item['id']], ['class' => 'btn btn-primary']) ?>
                                            <?= Html::a('Удалить', ['delete-article', 'id' => $item['id']], ['class' => 'btn btn-danger']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </article>
                </li>
                <?php Pjax::end();?>
            <?php }?>
        </ul>
</div>