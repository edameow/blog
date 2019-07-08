<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */


$this->title = 'Страница не найдена';
?>

<div class="st-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="primary" class="content-area padding-content white-color">
                    <main id="main" class="site-main" role="main">

                        <section class="error-404 not-found text-center">
                            <h1 class="404">404</h1>

                            <p class="lead">Такой страницы нет</p>
                            <p class="go-back-home">
                                <a href="<?= \yii\helpers\Url::home()?>">На главную</a>
                            </p>
                        </section><!-- .error-404 -->

                    </main><!-- #main -->
                </div><!-- #primary -->
            </div>
        </div>
    </div>
</div>