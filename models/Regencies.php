<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "regencies".
 *
 * @property string $id
 * @property string $province_id
 * @property string $name
 *
 * @property Districts[] $districts
 * @property Provinces $province
 */
class Regencies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'regencies';
    }

      public static function getKota()
    {
        return Self::find()->select(['name', 'id'])->indexBy('id')->column();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'province_id', 'name'], 'required'],
            [['id'], 'string', 'max' => 4],
            [['province_id'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Provinces::className(), 'targetAttribute' => ['province_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'province_id' => 'Province ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Districts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDistricts()
    {
        return $this->hasMany(Districts::className(), ['regency_id' => 'id']);
    }

    /**
     * Gets query for [[Province]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Provinces::className(), ['id' => 'province_id']);
    }

    public static function getKab($provincesID, $dependent = false)
    {
        // $subCategory = self::find()
        // ->select(['prodi as name', 'id'])
        // ->where(['id_fakultas' => $fakultasID])
        // ->asArray()
        // ->all();

        // return $subCategory;
        #var_dump($provincesID);
        $subCategory = self::find()->where(['province_id'=>$provincesID]);
        if ($dependent=="") {
            #$jancuk = $subCategory->select(['id','name as name'])->asArray()->all()
            #var_dump($subCategory->select(['id','name as name'])->asArray()->all());
            return $subCategory->select(['id','name as name'])->asArray()->all();
        } else {
            return $subCategory->select(['name'])->indexBy('id')->column();
        }
    }

    public function getRegencies()
    {
        return $this->hasOne(Regencies::className(), ['id' => 'id_kab']);
    }
}
