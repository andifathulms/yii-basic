<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mahasiswa".
 *
 * @property int $id
 * @property string $nim
 * @property string $nama
 * @property string $jekel
 * @property string $tgl
 * @property int $id_fakultas
 * @property int $id_prodi
 * @property string $email
 * @property string $alamat
 */
class Mahasiswa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mahasiswa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nim', 'nama', 'jekel', 'tgl', 'id_fakultas', 'id_prodi', 'id_provinsi', 'id_kab', 'email', 'alamat', 'foto'], 'required'],
            [['tgl'], 'safe'],
            [['id_fakultas', 'id_prodi'], 'integer'],
            [['nim'], 'string', 'max' => 18],
            [['nama', 'email'], 'string', 'max' => 50],
            [['jekel'], 'string', 'max' => 1],
            [['alamat', 'foto'], 'string', 'max' => 100],
            [['id_fakultas'], 'exist', 'skipOnError' => true, 'targetClass' => Fakultas::className(), 'targetAttribute' => ['id_fakultas' => 'id_fakultas']],
            [['id_prodi'], 'exist', 'skipOnError' => true, 'targetClass' => Prodi::className(), 'targetAttribute' => ['id_prodi' => 'id']],
            [['id_provinsi'], 'exist', 'skipOnError' => true, 'targetClass' => Provinces::className(), 'targetAttribute' => ['id_provinsi' => 'id']],
            [['id_kab'], 'exist', 'skipOnError' => true, 'targetClass' => Regencies::className(), 'targetAttribute' => ['id_kab' => 'id']],
            // [['foto'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, jfif'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nim' => 'Nim',
            'nama' => 'Nama',
            'jekel' => 'Jekel',
            'tgl' => 'Tgl',
            'id_fakultas' => 'Id Fakultas',
            'id_prodi' => 'Id Prodi',
            'id_provinsi' => "Id Provinsi",
            'id_kab' => "Id Kab/Kota",
            'email' => 'Email',
            'alamat' => 'Alamat',
            'foto' => 'Foto',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }

    public function getFakultas()
    {
       return $this->hasOne(Fakultas::className(), ['id_fakultas' => 'id_fakultas']);
    }

    Public function getProdi()
    {
        return $this->hasOne(Prodi::className(), ['id' => 'id_prodi']);
    }

    public function getRegencies()
    {
        return $this->hasOne(Regencies::className(), ['id' => 'id_kab']);
    }

    public function getProvinces()
    {
        return $this->hasOne(Provinces::className(), ['id' => 'id_provinsi']);
    }

    //  public function getProvince()
    // {
    //     return $this->hasOne(Provinces::className(), ['id' => 'id_provinsi']);
    // }

}
