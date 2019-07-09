<?php

namespace app\controllers;

use app\models\Article;
use app\models\ArticleTag;
use app\models\Comment;
use app\models\CommentForm;
use app\models\SignupForm;
use app\models\Tag;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = $this->getQuery(1);
        $data = $this->getAll($query);
        return $this->render('index', [
            'pages' => $data['pagination'],
            'models' => $data['model'],
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionPost($id, $sort = 0)
    {
        if (Article::find()->where(['id' => $id, 'status' => 1])->one()) {
            $model = Article::findOne($id);
            $tags = ArticleTag::find()->where(['article_id' => $id])->all();
            $commentQuery = Comment::find()->where(['article_id' => $id]);
            $this->sorting($sort, $commentQuery);
            $data = $this->getAll($commentQuery);
            $commentForm = new CommentForm();
            $commentTip = $this->getCommentTip($data['model']);
            return $this->render('post', [
                'model' => $model,
                'tags'  => $tags,
                'comments'  => $data['model'],
                'commentForm'  => $commentForm,
                'commentTip'  => $commentTip,
                'pages' => $data['pagination'],
            ]);
        } else {
            return $this->render('error');
        }
    }

    protected function getCommentTip($comments)
    {
        $count = count($comments);
        $strlen = strlen($count);
        $last = substr($count, -1);
        $penultimate = substr($count, -2, 1);

        if ($count) {
            if ($strlen == 1) {
                if ($count == 1) {
                    $tip = "й";
                } elseif ($count >= 2 && $count <= 4) {
                    $tip = "я";
                } elseif ($count >= 5 && $count <= 9) {
                    $tip = "ев";
                }
            } else {
                if ($penultimate == 1) {
                    $tip = "ев";
                } elseif ($penultimate >= 2 && $penultimate <= 9 || $penultimate == 0) {
                    if ($last == 1) {
                        $tip = "й";
                    } elseif ($last >= 2 && $last <= 4) {
                        $tip = "я";
                    } elseif ($last >= 5 && $last <= 9 || $last == 0) {
                        $tip = "ев";
                    }
                }
            }
            return $tip;
        }
    }

    public function actionDeleteComment($id)
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->moderator) {
            $model = $this->findComment($id);
            $article_id = $model->article_id;
            $model->deleteComment();
            return $this->redirect(['site/post', 'id' => $article_id]);
        } else return $this->render('error');
    }

    public function actionCategory($id)
    {
        $query = $this->getQuery(0, $id);
        $data = $this->getAll($query);
        return $this->render('category',  [
            'pages' => $data['pagination'],
            'models' => $data['model'],
        ]);
    }

    public function actionTag($tags)
    {
        $query = $this->getQuery(0, 0, $tags);
        $data = $this->getAll($query);
        if ($data) {
            return $this->render('category',  [
                'pages' => $data['pagination'],
                'models' => $data['model'],
            ]);
        }
        $models = null;
        return $this->render('category',  [
            'models' => $models,
        ]);
    }

    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->signUp()) {
                $user = Yii::$app->user->identity;
                $this->sendEmail($user);
                return $this->goHome();

            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionComment($id)
    {
        $model = new CommentForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->saveComment($id)) {
                return $this->redirect(['site/post', 'id' => $id]);
            }
        }
    }

    protected function findComment($id)
    {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function sendEmail($user)
    {
        $text = "Регистрация прошла успешно, <br>
                 <b>$user->name</b>";
        Yii::$app->mailer->compose()
            ->setFrom('galogen41001@mail.ru')
            ->setTo($user->email)
            ->setSubject('Регистрация на сайте прошла успешно')
            ->setHtmlBody($text)
            ->send();
    }


    protected function sorting($sort, $query)
    {
        if ($sort) {
            if ($sort == 'old') {
                $query->orderBy(['id' => SORT_ASC]);
            } else {
                $query->orderBy(['id' => SORT_DESC]);
            }
        }
    }

    protected function getAll($query)
    {
        if ($query) {
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 5, 'pageSizeParam' => false, 'forcePageParam' => false]);
            $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
            $data['model'] = $models;
            $data['pagination'] = $pages;
            return $data;
        }
    }

    protected function getQuery($index = 1, $category_id = 0, $tags = 0)
    {
        $query = $this->indexSearch($index);
        if (!$query) {
            $query = $this->tagSearch($tags);
        }
        if (!$query) {
            $query = $this->categorySearch($category_id);
        }
        if ($query) {
            return $query->orderBy(['id' => SORT_DESC]);
        }
    }

    protected function indexSearch($index)
    {
        if ($index) {
            $query = Article::find()->where(['status' => 1]);
            return $query;
        }
    }

    protected function categorySearch($category_id)
    {
        if ($category_id != 0) {
            $query = Article::find()->where(['category_id' => $category_id, 'status' => 1]);
            return $query;
        }
    }

    protected function tagSearch($tags)
    {
        if ($tags) {
            $array = $this->getTagArray($tags);
            $tagIdArr = $this->getTagId($array);
            if ($tagIdArr) {
                $articleIdArray = $this->getArticleIdArray($tagIdArr);
                $result = $this->getResultId($articleIdArray);
                $query = Article::find()->where(['status' => 1, 'id' => $result]);
                return $query;
            }
        }
    }

    protected function getTagArray($tags)
    {
        $arr = explode(' ', $tags);
        return $arr;
    }

    protected function getTagId($arr)
    {
        foreach ($arr as $str) {
            $tagId = Tag::find()->where(['title' => $str])->one();
            if ($tagId) {
                $tagIdArr[] = $tagId->id;
            } else return;
        } return $tagIdArr;
    }

    protected function getArticleIdArray($tagIdArr)
    {
        foreach ($tagIdArr as $value) {
            $array[] = array_map('current', ArticleTag::find()->select('article_id')->asArray()->where(['tag_id' => $value])->all());
        } return $array;
    }

    protected function getResultId($articleIdArray)
    {
        //compare arrays if 2+ tags
        if (count($articleIdArray) >= 2) {
            for ($i = 1; $i < count($articleIdArray); $i++) {
                if ($i == 1) {
                    $result = array_uintersect($articleIdArray[0], $articleIdArray[$i], "strcasecmp");
                } else {
                    $result = array_uintersect($result, $articleIdArray[$i], "strcasecmp");
                }
            } if ($result) {
                return $result;
            }
            //get article array if 1 tag
        } else {
            $result = $articleIdArray;
            $result = $result[0];
            return $result;
        }
    }
}
