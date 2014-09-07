<?php

/**
 * This is the model class for table "interriors".
 *
 * The followings are the available columns in table 'interriors':
 * @property integer $id
 * @property string $fileName
 * @property integer $isComplex
 * @property string $strCorners
 * @property string $strProjection
 */
class Interriors extends CActiveRecord
{
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'interriors';
	}
        
        protected function beforeSave(){
            if(!parent::beforeSave())
                return false;
            ;
            if($this->scenario=="Add" && $document=CUploadedFile::getInstance($this,'fileName')){
                $this->fileName=$document;
                $this->createThumb($document->tempName);
                $this->fileName->saveAs(
                        Yii::getPathOfAlias('webroot.images.uploads').DIRECTORY_SEPARATOR.$this->fileName);
            }
            return true;
        }
        protected function createThumb($filename){
            $newname=Yii::getPathOfAlias('webroot.images.uploads.thumbs').DIRECTORY_SEPARATOR."thumb_".$this->fileName;
            $source = imagecreatefromjpeg( $filename );
            list( $w, $h ) = getimagesize( $filename );
            $thumb = imagecreatetruecolor(200, 125);
            imagecopyresampled( $thumb, $source, 0, 0, 0, 0, 200, 125, $w, $h );
            imagejpeg( $thumb, $newname, 75 );

            imagedestroy( $thumb );
            imagedestroy( $source );

        }
	/**
	 * @return array validation rules for model attributes.
	 */        
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fileName', 'file', 'on' => 'edit', 'allowEmpty'=>FALSE, 'mimeTypes' =>"image/jpeg"),
                        array('isComplex', 'boolean'),
                        array('fileName', 'length', 'max'=>512),
			array('strCorners', 'length', 'max'=>512),
			array('strProjection', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
//			array('fileName', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fileName' => 'Выберите файл с интерьером',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('fileName',$this->fileName,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Interriors the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
