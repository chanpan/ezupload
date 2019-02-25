<?php

namespace backend\modules\uploads\controllers;

use Yii;
use backend\modules\uploads\models\Files;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FilesController implements the CRUD actions for Files model.
 */
class FilesController extends Controller
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
     * Lists all Files models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Files::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Files model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    private function getMaxForder(){
        $user_id = \cpn\chanpan\classes\CNUser::get_user_id();
        $max = Files::find()->where('deleted not in(0,3) AND created_by=:created_by',[':created_by'=>$user_id])->orderBy(['forder'=>SORT_ASC])->one();
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
     * Creates a new Files model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUploadFile()
    {
        ini_set('post_max_size', '11164M');
        ini_set('upload_max_filesize', '11164M');
        $error_arr = [];
        $model = new Files();
        $folder_id = \Yii::$app->request->get('folder_id', '');
        if (\Yii::$app->request->isPost) {
            $files  = \yii\web\UploadedFile::getInstancesByName('name');
            $folder_id = \Yii::$app->request->post('folder_id', '');
           // \yii\helpers\VarDumper::dump(Yii::getAlias('@storage'));
            $path   = Yii::getAlias('@storage') . "/web/images/";
            foreach ($files as $k=> $file) {
                //\appxq\sdii\utils\VarDumper::dump($file);
                $new_file_name = date('Ymd_His').'_'.rand(10, 1000);
                $model->id = \appxq\sdii\utils\SDUtility::getMillisecTime();
                $model->file_name = "{$new_file_name}.{$file->extension}";
                $model->file_name_org = $file->name;
                $model->folder_id = $folder_id;
                $model->file_detail = \appxq\sdii\utils\SDUtility::array2String($file);
                $model->deleted = 1;
                $model->created_by = isset(Yii::$app->user->id) ? Yii::$app->user->id : '';
                $model->created_date = date('Y-m-d H:i:s');
                $model->forder = $this->getMaxForder();
                //\appxq\sdii\utils\VarDumper::dump($file);
                
                if($file->saveAs("{$path}/{$new_file_name}.{$file->extension}")){
                    
                    if(!$model->save()){
                        $error_arr[$k] = ['file_name'=>$file->name, 'message'=>$model->errors];
                        \appxq\sdii\utils\VarDumper::dump($error_arr);
                    }
                    
                }
            }     
            return \cpn\chanpan\classes\CNMessage::getSuccess('Upload file success', $error_arr);
            
        }

        return $this->renderAjax('upload-file', [
            'model' => $model,
            'folder_id'=>$folder_id
        ]);
    }

    /**
     * Updates an existing Files model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Files model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Files model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Files the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Files::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
