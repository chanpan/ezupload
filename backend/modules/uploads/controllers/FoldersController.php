<?php

namespace backend\modules\uploads\controllers;

use Yii;
use backend\modules\uploads\models\Folders;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FoldersController implements the CRUD actions for Folders model.
 */
class FoldersController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Folders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $id = \Yii::$app->request->get('id','0');
        $folders = Folders::find()->where('deleted not in(0,3)')->andWhere('parent_id=:parent_id',[':parent_id'=>$id])->orderBy(['forder'=>SORT_ASC])->all();
        $files = [];
        
        if($id != 0){
            $files = \backend\modules\uploads\models\Files::find()->where('folder_id = :folder_id AND deleted not in(0,3)', [':folder_id'=>$id])->all();
        }
        return $this->render('index', [
            'folders' => $folders,
            'files'=>$files
        ]);
    }

    /**
     * Displays a single Folders model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function getView($id)
//    {
//        $model = Folders::findOne($id);
//        return $this->renderAjax('_items', [
//            'v' => $model
//        ]);
//    }
    private function getViewById($id){
        $model = Folders::findOne($id);
        return $this->renderAjax('_item_folder_one', [
            'v' => $model
        ]);
    }
    private function getMaxForder(){
        $user_id = \cpn\chanpan\classes\CNUser::get_user_id();
        $max = Folders::find()->where('deleted not in(0,3) AND created_by=:created_by',[':created_by'=>$user_id])->orderBy(['forder'=>SORT_ASC])->one();
        if($max){
             $max_order = (int)$max['forder']-1;
             if($max_order == 0){
                 $max_order = 100000;
             }
             return $max_order;
        }
        return 100000;
    }
    /**
     * Creates a new Folders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        if (Yii::$app->request->post()) {
            $folder_value = Yii::$app->request->post('folder_value', '');
            $parent_id = Yii::$app->request->post('parent_id', '0');
            $icon = Yii::$app->request->post('icon', 'fa fa-folder');
            
            $model = new Folders();
            $model->id = time();
            $model->name = $folder_value;
            $model->parent_id = $parent_id;
            $model->icon = $icon;
            $model->detail = '';
            $model->deleted = 1;
            $model->created_by = isset(Yii::$app->user->id)?Yii::$app->user->id:'';
            $model->created_date = date('Y-m-d H:i:s');
            $model->forder = $this->getMaxForder();
            if($model->save()){
                return $this->getViewById($model->id);
            }
        } 
    }

    /**
     * Updates an existing Folders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_by = isset(Yii::$app->user->id)?Yii::$app->user->id:'';
            $model->update_date = date('Y-m-d H:i:s');
            if($model->save()){
                return \cpn\chanpan\classes\CNMessage::getSuccess("Update folder {$model->name} success");
            }
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Folders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        $id = \Yii::$app->request->post('id', '');
        $model = $this->findModel($id);
        $model->deleted = 3;
        if($model->save()){
            return \cpn\chanpan\classes\CNMessage::getSuccess('Delete success');
        }

    }

    /**
     * Finds the Folders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Folders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Folders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
