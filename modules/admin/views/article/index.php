<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статьи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="list-unstyled">
        <?php foreach ($model as $item) { ?>
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
                                    <header class="entry-header text-uppercase">
                                        <h6>
                                            <?= $item->category->title?>
                                        </h6>
                                        <h1 class="entry-title">
                                            <?= $item['title']?>
                                        </h1>
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
                                        <?= Html::a('Просмотр', Url::to(['article/view', 'id' => $item['id']]), ['class' => 'btn btn-success'])?>
                                    </div>
                                </div>
                            </div>
                        </div>
                </article>
            </li>
        <?php }?>
    </ul>
</div>
