<?php

/**
 * This is the model class for table "categorizedimages".
 *
 * The followings are the available columns in table 'categorizedimages':
 * @property integer $id
 * @property integer $imgID
 * @property integer $catID
 */
class CategorizedImages extends CActiveRecord
{
        public $allCats;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'categorizedimages';
	}

        public function behaviors(){
            return array(
                'activerecord-relation'=>array(
                    'class'=>'application.extensions.behaviors.activerecord-relation.EActiveRecordRelationBehavior',
                    ),
                );
        }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('imgID, catID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, imgID, catID', 'safe', 'on'=>'search'),
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
                    'filename' =>array(self::BELONGS_TO,'Images','imgID'),
                    'category'=>array(self::BELONGS_TO,'Category','catID')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'imgID' => 'Img',
			'catID' => 'Cat',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('imgID',$this->imgID);
		$criteria->compare('catID',$this->catID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CategorizedImages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * @was array. Список текущих категорий
         * @new array. Список новых категорий
	 * @return 
	 */
        public static function getDiff()
	{
		return parent::model($className);
	}

}
