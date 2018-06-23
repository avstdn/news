<?php
namespace backend\controllers;

use app\models\MembershipFunctions;
use backend\models\Articles;
use common\models\LoginForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'actions' => ['login', 'error'],
//                        'allow' => true,
//                    ],
//                    [
//                        'actions' => ['logout', 'index'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
//        ];
//    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create', 'update'],
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
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
        $articles = Articles::find()->orderBy(['id' => SORT_DESC])->limit(20)->all();

        return $this->render('index', compact('articles'));
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

//        return $this->goHome();
        return $this->redirect('login');
    }

    public function actionShowNews($id)
    {
        if (!$article = Articles::findOne($id)) {
            throw new NotFoundHttpException("Статья $id не найдена");
        }

        $this->layout = false;

        return $this->render('news', compact('article'));
    }

    public function actionSettings()
    {
        $mf = MembershipFunctions::findOne(0);

        if ($mf->load(Yii::$app->request->post())) {
            $mf->name = 'all';
            $mf->user_id = Yii::$app->user->id;
            if ($mf->save()) {
                $this->setFlash('success', "Функции принадлежности обновлены");
            } else {
                $this->setFlash('danger', "Ошибка при обновлении");
            }
        }

        $coords = $mf->coords;
        $defaultCoords = MembershipFunctions::findOne(1)->coords;

        return $this->render('settings', compact('mf', 'defaultCoords', 'coords'));
    }

//    public function beforeAction($action)
//    {
//        Yii::$app->language = 'ru-RU';
//
//        return parent::beforeAction($action);
//    }

    protected function setFlash($type, $message)
    {
        Yii::$app->getSession()->setFlash($type, $message);
    }
}
