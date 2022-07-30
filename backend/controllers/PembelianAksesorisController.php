<?php

namespace backend\controllers;

use backend\models\PembelianAksesoris;
use backend\models\PembelianAksesorisSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\ServerErrorHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

// Models
use backend\models\Aksesoris;

/**
 * PembelianAksesorisController implements the CRUD actions for PembelianAksesoris model.
 */
class PembelianAksesorisController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all PembelianAksesoris models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PembelianAksesorisSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PembelianAksesoris model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PembelianAksesoris model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PembelianAksesoris();
        $daftarPembelian = \Yii::$app->session->get(PembelianAksesoris::SESSION_KEY);

        if ($this->request->isPost) {      // Jika ingin disimpan

            if ($model->load($this->request->post())) {

                $model->no_inv = ''; // update no invoice, sementara dikosongkan dl

                // Update total harga
                $hargaTotal = 0;
                foreach ($daftarPembelian as $key => $item) :
                    $hargaTotal += $item['sub-total'];
                endforeach;
                $model->harga_total = $hargaTotal;

                // Simpan model PembelianAksesoris, tampilkan kalo terjadi error
                try {
                    $model->save();
                } catch (\Exception $e) {
                    throw new ServerErrorHttpException($e);
                }

                $model->refresh();  // setelah di save, model direfresh untuk diambil id auto incrementnya

                // Membuat array DaftarPembelian yang akan disimpan secara bersamaan
                $insertDaftarPembelian = [];
                foreach ($daftarPembelian as $key => $item) {
                    // Buat model PembelianAksesorisDetail
                    $itemDataDaftarPembelian = [
                        $model->id, $item['id'], $item['jumlah'], $item['harga']
                    ];

                    $insertDaftarPembelian[] = $itemDataDaftarPembelian;

                    // Updating stock on hand
                    $stok_akhir = Aksesoris::findOne($item['id'])->stock_on_hand;

                    \Yii::$app->db->createCommand()->update(
                        'aksesoris',
                        [
                            'stock_on_hand' => $stok_akhir + $item['jumlah']
                        ],
                        'id = :id',
                        [':id' => $item['id']]
                    )->execute();
                }

                // Simpan semua model PembelianAksesorisDetail secara bersamaan, tampilkan kalo terjadi error
                try {
                    \Yii::$app->db->createCommand()->batchInsert(
                        'pembelian_aksesoris_detail',
                        [
                            'pembelian_aksesoris_id', 'aksesoris_id', 'qty', 'harga_beli'
                        ],
                        $insertDaftarPembelian
                    )->execute();
                } catch (\Exception $e) {
                    throw new ServerErrorHttpException($e);
                }

                // kembali ke view/pembelian-aksesoris-index
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        // Ketika akan membuat pembelian aksesori, kosongkan $_SESSION daftar aksesorisnya.
        \Yii::$app->session->has(PembelianAksesoris::SESSION_KEY) ? \Yii::$app->session->remove(PembelianAksesoris::SESSION_KEY) : '';
        $daftarPembelian = [];

        return $this->render('create', [
            'model' => $model,
            'daftarPembelian' => $daftarPembelian
        ]);
    }

    /**
     * Updates an existing PembelianAksesoris model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PembelianAksesoris model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PembelianAksesoris model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PembelianAksesoris the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PembelianAksesoris::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Menambahkan aksesoris ke dalam invoice pembelian.
     * Item aksesoris sementara dimasukkan ke dalam $_SESSION.
     * Fungsi yang menerima panggilan Ajax dari JS kemudian melempar hasilnya ke
     * view dengan Ajax.
     */
    public function actionTambahAksesoris()
    {
        if (!\Yii::$app->request->isAjax) {
            throw new ForbiddenHttpException('Request yang dikirim bukan ajax');
        }

        $aksesorisId = \Yii::$app->request->post('aksesorisId');
        $jumlah = \Yii::$app->request->post('jumlah');
        $harga = \Yii::$app->request->post('harga');

        $sql = "SELECT a.id,a.nama,m.nama merk FROM aksesoris a, merk_aksesoris m WHERE a.merk_aksesoris_id=m.id AND a.id=" . $aksesorisId;

        $model = Aksesoris::findBySql($sql)->asArray()->one();

        if (\Yii::$app->session->has(PembelianAksesoris::SESSION_KEY)) {
            $pembelianAksesoris = \Yii::$app->session->get(PembelianAksesoris::SESSION_KEY);
            $dataSudahAda = false;
            foreach ($pembelianAksesoris as $key => &$item) : // Gunakan & di depan nama variabel untuk akses pointer.
                if ($item['id'] == $aksesorisId) :
                    $item['jumlah'] += $jumlah;
                    $item['sub-total'] = $item['jumlah'] * $item['harga'];
                    $dataSudahAda = true;
                    break;
                endif;
            endforeach;

            if (!$dataSudahAda) {
                array_push($pembelianAksesoris, array(
                    'id' => $model['id'],
                    'nama' => $model['nama'],
                    'merk' => $model['merk'],
                    'jumlah' => $jumlah,
                    'harga' => $harga,
                    'sub-total' => $jumlah * $harga
                ));
            }
        } else {
            $pembelianAksesoris = array(array(
                'id' => $model['id'],
                'nama' => $model['nama'],
                'merk' => $model['merk'],
                'jumlah' => $jumlah,
                'harga' => $harga,
                'sub-total' => $jumlah * $harga
            ));
        }

        $session = \Yii::$app->session;
        $session[PembelianAksesoris::SESSION_KEY] = $pembelianAksesoris;

        return json_encode([
            'hasilAjax' => $this->renderAjax('_daftar-pembelian', ['model' => $pembelianAksesoris]),
            'jmlAksesoris' => count($pembelianAksesoris),
        ]);
    }

    public function actionHapusAksesoris()
    {
        if (!\Yii::$app->request->isAjax) {
            throw new ForbiddenHttpException('Request yang dikirim bukan ajax');
        }

        $aksesorisId = \Yii::$app->request->post('aksesorisId');
        $pembelianAksesoris = \Yii::$app->session->get(PembelianAksesoris::SESSION_KEY);

        for ($i = 0; $i < sizeof($pembelianAksesoris); $i++) {
            if ($pembelianAksesoris[$i]['id'] == $aksesorisId) {
                array_splice($pembelianAksesoris, $i, 1);
                break;
            }
        }

        \Yii::$app->session->set(PembelianAksesoris::SESSION_KEY, $pembelianAksesoris);

        return json_encode([
            'hasilAjax' => $this->renderAjax('_daftar-pembelian', ['model' => $pembelianAksesoris]),
            'jmlAksesoris' => count($pembelianAksesoris),
        ]);
    }

    public function actionResetAksesoris()
    {
        if (!\Yii::$app->request->isAjax) {
            throw new ForbiddenHttpException('Request yang dikirim bukan ajax');
        }

        if (\Yii::$app->session->has(PembelianAksesoris::SESSION_KEY)) {
            \Yii::$app->session->remove(PembelianAksesoris::SESSION_KEY);
        }

        return $this->renderAjax('_daftar-pembelian', [
            'model' => [],
        ]);
    }

    public function actionListAksesoris()
    {
        if (!\Yii::$app->request->isAjax) {
            throw new ForbiddenHttpException('Request yang dikirim bukan ajax');
        }

        $jenis = \Yii::$app->request->post('jenisId');
        $merk = \Yii::$app->request->post('merkId');

        if ($jenis != 0 && $merk != 0) {
            $model = Aksesoris::find()->where(['jenis_aksesoris_id' => $jenis])->andWhere(['merk_aksesoris_id' => $merk])->asArray()->all();
        } elseif ($jenis == 0 && $merk == 0) {
            $model = Aksesoris::find()->asArray()->all();
        } else {
            if ($merk != 0) {
                $model = Aksesoris::find()->where(['merk_aksesoris_id' => $merk])->asArray()->all();
            } else {
                $model = Aksesoris::find()->where(['jenis_aksesoris_id' => $jenis])->asArray()->all();
            }
        }

        $list = ArrayHelper::map($model, 'id', 'nama');

        return $this->renderAjax('_list-aksesoris', ['model' => $list]);
    }
}
