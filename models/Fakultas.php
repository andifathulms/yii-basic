<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fakultas".
 *
 * @property int $id_fakultas
 * @property int $kode_fakultas
 * @property string $nama_fakultas
 */
class Fakultas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fakultas';
    }

    public static function getFakultas()
    {
        return Self::find()->select(['nama_fakultas', 'id_fakultas'])->indexBy('id_fakultas')->column();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_fakultas', 'nama_fakultas'], 'required'],
            [['kode_fakultas'], 'integer'],
            [['nama_fakultas'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_fakultas' => 'Id Fakultas',
            'kode_fakultas' => 'Kode Fakultas',
            'nama_fakultas' => 'Nama Fakultas',
        ];
    }

    public function getMahasiswa()
    {
        
        return $this->hasOne(Mahasiswa::className(),['id_fakultas'=>'id_fakultas']);
    }
}
