<?php
use yii\helpers\Html;
use  yii\helpers\Url;
?>
<div class="col-md-4" data-sticky_column>
    <div class="primary-sidebar">
        <aside class="widget border pos-padding">
            <h3 class="widget-title text-uppercase text-center">Категории</h3>
            <ul>
                <?php foreach ($category as $item) {?>
                    <li>
                        <a href="<?= Url::to(['site/category', 'id' => $item['id']])?>"><?= $item['title']?></a>
                    </li>
                <?php }?>
            </ul>
        </aside>
        <?php if ($popular) {?>
            <aside class="widget col-sm-6 col-md-12">
                <h3 class="widget-title text-uppercase text-center">Популярные посты</h3>
                <?php foreach ($popular as $item) {?>
                    <div class="popular-post">
                        <?= Html::a(Html::img("/web/images/articles/{$item['image']}"), Url::to(['site/post', 'id' => $item['id']]))?>
                        <div class="p-content">
                            <a href="<?= Url::to(['site/post', 'id' => $item['id']])?>" class="text-uppercase"><?= $item['title']?></a>
                            <span class="p-date"><?= $item->date?></span>
                        </div>
                    </div>
                <?php }?>
            </aside>
        <?php }?>
        <aside class="widget pos-padding col-sm-6 col-md-12">
            <h3 class="widget-title text-uppercase text-center">Последние посты</h3>
            <?php foreach ($latest as $item) {?>
                <div class="thumb-latest-posts">
                    <div class="media">
                        <div class="media-left">
                            <?= Html::a(Html::img("/web/images/articles/{$item['image']}"), Url::to(['site/post', 'id' => $item['id']]), ['class' => 'popular-img'])?>
                        </div>
                        <div class="p-content">
                            <a href="<?= Url::to(['site/post', 'id' => $item['id']])?>" class="text-uppercase"><?= $item['title']?></a>
                            <span class="p-date"><?= $item->date?></span>
                        </div>
                    </div>
                </div>
            <?php }?>
        </aside>
    </div>
</div>