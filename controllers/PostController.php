<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\helpers\Helper;
use app\helpers\Constant;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller {

    const PAGE_SIZE = 10;

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    //'publish' => ['POST'],
                    //'unpublish' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Check user logged in or not
     * @throws Exception
     */
    public function checkAccess() {
        if (Yii::$app->getUser()->getIsGuest()) {
            throw new Exception(Yii::t('app', 'You do not have permissions to do this action.'));
        }
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        $offset = (int) Yii::$app->getRequest()->get('offset', 0);
        $query = Post::find()
                ->select('id, title, slug, thumbnail_url, summary, published_time, created_by, updated_by')
                ->andWhere(['status' => Constant::STATUS_PUBLISHED])
                ->andWhere(['<=', 'published_time', time()])
                ->orderBy('published_time desc')
                ->with('createdBy')
                ->offset($offset)
                ->limit(self::PAGE_SIZE);

        $posts = $query->all();

        if (count($posts) >= self::PAGE_SIZE) {
            $nextFrom = $offset + self::PAGE_SIZE;
        } else {
            $nextFrom = null;
        }

        $prevFrom = null;
        if ($offset > 0) {
            $prevFrom = $offset >= self::PAGE_SIZE ? $offset - self::PAGE_SIZE : 0;
        }


        return $this->render('index', ['posts' => $posts, 'prevFrom' => $prevFrom, 'nextFrom' => $nextFrom]);
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionAdmin() {
        $this->checkAccess();
        $identity = Yii::$app->getUser()->getIdentity();

        $query = Post::find();
        
        if (!$identity->is_admin) {
            $query->andWhere(['created_by' => $identity->id]);
            $query->andWhere(['in', 'status', [Constant::STATUS_PUBLISHED, Constant::STATUS_UNPUBLISHED]]);
        }

        $model = new Post(['scenario' => 'search']);
        $formName = $model->formName();
        $model->load(Yii::$app->getRequest()->getQueryParams(), $formName);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);

        return $this->render('admin', [
                    'searchModel' => $model,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Publish a post
     * 
     * @param type $id
     * @throws Exception
     */
    public function actionPublish($id) {
        if (!Helper::isAdmin()) {
            throw new Exception(Yii::t('app', 'You do not have permissions to execute this action'));
        }

        $model = Post::find()->where(['id' => $id])->one();

        if ($model) {
            $model->status = Constant::STATUS_PUBLISHED;
            $model->published_time = time();
            
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'The post was published.'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', implode('<br/>', $model->getFirstErrors())));
            }
        }
        
        return $this->redirect(['/post/admin']);
    }

    public function actionUnpublish($id) {
        if (!Helper::isAdmin()) {
            throw new Exception(Yii::t('app', 'You do not have permissions to execute this action'));
        }

        $model = Post::find()->where(['id' => $id])->one();

        if ($model) {
            $model->status = Constant::STATUS_UNPUBLISHED;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'The post was unpublished.'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', implode('<br/>', $model->getFirstErrors())));
            }
        }

        return $this->redirect(['/post/admin']);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $id = (int) $id;
        $post = Post::find()->with('createdBy')->where(['id' => $id])->one();
        
        if (!$post) {
            throw new NotFoundHttpException(Yii::t('app', 'The post not found'));
        }
        
        if ($post->status != Constant::STATUS_PUBLISHED && (!Helper::isOwner($post->created_by) && !Helper::isAdmin())) {
            throw new NotFoundHttpException(Yii::t('app', 'The post is not published.'));
        }
        elseif ($post->status == Constant::STATUS_PUBLISHED && $post->published_time > time() && (!Helper::isOwner($post->created_by) && !Helper::isAdmin())) {
            throw new NotFoundHttpException(Yii::t('app', 'The post is not published.'));
        }

        return $this->render('view', [
                    'model' => $post,
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $this->checkAccess();
        
        $model = new Post();
        if (Helper::isAdmin()) {
            $model->setScenario('admin');
        }
        else {
            $model->setScenario('create');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/post/view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $this->checkAccess();
        
        $model = $this->findModel($id);
        if (Helper::isAdmin()) {
            $model->setScenario('admin');
        }
        else {
            $model->setScenario('update');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/post/view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
