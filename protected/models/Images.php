<?php

/**
 * This is the model class for table "images".
 *
 * The followings are the available columns in table 'images':
 * @property integer $id
 * @property string $fileName
 */
class Images extends CActiveRecord
{
        public $imgCats=null;
        public $catId=0;
        
        public function setImgCats($val){
            if(is_array($val)){
                $this->imgCats=$val;
            }
        }
        public function getImgCats(){
            if(!$this->isNewRecord && !$this->imgCats){
                $this->imgCats=CHtml::listData($this->cats,"id","catID");
            }
            return $this->imgCats;
        }
        
        public function getCatId(){
            return $this->catId;
        }
        
        public function setCatId($val){
            $this->catId=$val;
        }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'images';
	}

        public function behaviors(){
            return array(
                'activerecord-relation'=>array(
                    'class'=>'application.extensions.behaviors.activerecord-relation.EActiveRecordRelationBehavior',
                    ),
                );
        }
        protected function afterSave(){
            parent::afterSave();

            if(!$this->isNewRecord){
                $catalog=new CategorizedImages();
                $catalog->deleteAll("imgID = ".$this->id);
            }else{
                $this->createThumbAndResize($this->fileName->tempName);
            }
            foreach($this->imgCats as $cat){
                $catImg=new CategorizedImages();
                $catImg->imgID=$this->id;
                $catImg->catID=$cat;
                $catImg->save();
            }
            return true;
        }

        protected function afterDelete(){
            parent::afterDelete();

            $catalog=new CategorizedImages();
            $catalog->deleteAll("imgID = ".$this->id);
        }
        
        protected function createThumbAndResize($filename){
            $newname=Yii::getPathOfAlias('webroot.images.uploads').DIRECTORY_SEPARATOR.$this->fileName;
            $thumbname=Yii::getPathOfAlias('webroot.images.uploads.thumbs').DIRECTORY_SEPARATOR."thumb_".$this->fileName;
            $source = imagecreatefromjpeg( $filename );
            list( $w, $h ) = getimagesize( $filename );
            $resized = imagecreatetruecolor(800, 500);
            imagecopyresampled( $resized, $source, 0, 0, 0, 0, 800, 500, $w, $h );
            imagejpeg( $resized, $newname, 75 );
            
            $thumb = imagecreatetruecolor(200, 125);
            imagecopyresampled( $thumb, $source, 0, 0, 0, 0, 200, 125, $w, $h );
            imagejpeg( $thumb, $thumbname, 75 );

            imagedestroy( $thumb );
            imagedestroy( $source );
            imagedestroy( $resized );

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
                        array('fileName', 'unique', 'message'=>"Файл {fileName} уже существует в базе"),
                        array('ImgCats', 'type', 'type' => 'array', 'on'=>'Edit,Add'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
                        array('catId', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fileName' => 'Выберите файл',
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
            if($this->catId){
                $criteria->with=array(
                    'cats',);
                $criteria->together=true;
		$criteria->compare('cats.catID',$this->catId);
            }
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
//                    'imgs'=>array(self::HAS_MANY, 'CategorizedImages','imgID'),
                    'cats'=>array(self::HAS_MANY, 'CategorizedImages','imgID'),
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Images the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
