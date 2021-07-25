<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prodi".
 *
 * @property int $id
 * @property int $id_fakultas
 * @property string $prodi
 * @property string $keterangan
 *
 * @property Fakultas $fakultas
 */
class Prodi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prodi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_fakultas', 'prodi', 'keterangan'], 'required'],
            [['id_fakultas'], 'integer'],
            [['prodi', 'keterangan'], 'string', 'max' => 50],
            [['id_fakultas'], 'exist', 'skipOnError' => true, 'targetClass' => Fakultas::className(), 'targetAttribute' => ['id_fakultas' => 'id_fakultas']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_fakultas' => 'Id Fakultas',
            'prodi' => 'Prodi',
            'keterangan' => 'Keterangan',
        ];
    }

    /**
     * Gets query for [[Fakultas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFakultas()
    {
        return $this->hasOne(Fakultas::className(), ['id_fakultas' => 'id_fakultas']);
    }

    public static function getProdiList($fakultasID, $dependent = false)
    {
        // $subCategory = self::find()
        // ->select(['prodi as name', 'id'])
        // ->where(['id_fakultas' => $fakultasID])
        // ->asArray()
        // ->all();

        // return $subCategory;

        $subCategory = self::find()->where(['id_fakultas'=>$fakultasID]);
        if ($dependent=="") {
            return $subCategory->select(['id','prodi as name'])->asArray()->all();
        } else {
            return $subCategory->select(['prodi'])->indexBy('id')->column();
        }
    }
}
