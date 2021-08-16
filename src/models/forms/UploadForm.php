<?php

namespace models\forms;

use models\forms\base\Form;
use models\Uploads;
use models\UploadsQuery;
use Yii;

class UploadForm extends Form
{
    const LICENSE_TYPE_REVSHARE = 'revshare';
    const LICENSE_TYPE_EXCLUSIVE = 'exclusive';
    const LICENSE_TYPE_PRIVATE_FOR_TARGET_PRICE = 'private for target price';

    //------JSON FIELDS OF SHEER UPLOAD
    public $_TITLE;
    public $_DESCRIPTION;
    public $_GENRE;

    public $license_type;
    public $note;
    public $exclusive_rights_cost;
    public $ppv_cost;
    public $release_date;

    protected $sheerUploadId = false;
    protected $validateJsonFields = true;
    protected $user_id;

    /**
     * @var Uploads
     */
    private $lastUpload;

    public static function createAndSaveFromRequest()
    {
        $request = Yii::$app->request;
        $videoUrl = $request->post('video_url');
        $sheerId = $request->post('sheer_id');
        $release_date = $request->post('upload_date');
        $description = $request->post('description');

        $existedUpload = UploadsQuery::model()
            ->filterByUserId($sheerId)
            ->filterByUrl($videoUrl)
            ->one();

        $form = new static;

        if ($existedUpload) {
            //edit existed upload
            //but if we have information loss - throw error
            /** @var static $formFromExistedUpload */
            $formFromExistedUpload = self::createFromUpload($existedUpload);
            if (!empty($formFromExistedUpload->_DESCRIPTION) && empty($description)) {
                throw new \Exception("video_url already exists with description filled");
            }
            if (!empty($formFromExistedUpload->release_date) && empty($release_date)) {
                throw new \Exception("video_url already exists with release_date filled");
            }
            $form = $formFromExistedUpload;
        }

        $form->license_type = self::LICENSE_TYPE_REVSHARE;
        $form->user_id = $sheerId;
        $form->release_date = $release_date;
        $form->_DESCRIPTION = $description;
        $form->note = UploadsQuery::AUTOMATICALLY_LOADED;

        if (!$form->save()) {
            throw new \Exception("can't save upload info");
        }

        $upload = $form->getSheerUpload();
        $upload->xvideos_id = $request->post('xvideos_id');
        $upload->save(false);
        $upload->saveURL($videoUrl);

        return $form;
    }

    public static function createFromUpload(Uploads $sheerUpload)
    {
        $form = new static;

        $form->license_type = $sheerUpload->licence_type;
        $form->note = $sheerUpload->note;
        $form->exclusive_rights_cost = $sheerUpload->exclusive_rights_cost;
        $form->sheerUploadId = $sheerUpload->upload_id;
        $form->release_date = $sheerUpload->release_date;
        $form->ppv_cost = $sheerUpload->ppv_cost;
        $form->user_id = $sheerUpload->user_id;

        foreach (Uploads::JSON_PARAMS as $field => $label) {
            $form->$field = $sheerUpload->getJsonParam($field);
        }

        return $form;
    }

    public function save()
    {
        /** @var Uploads $sheerUpload */
        $sheerUpload = $this->isEditForm()
            ? UploadsQuery::model()
                ->filterByUploadId($this->sheerUploadId)
                ->filterByUserId($this->user_id
                    ? $this->user_id
                    : \Yii::$app->user->getId())
                ->one()
            : new Uploads();

        $sheerUpload->licence_type = $this->license_type;
        $sheerUpload->exclusive_rights_cost = $this->exclusive_rights_cost;
        $sheerUpload->ppv_cost = $this->ppv_cost;
        $sheerUpload->note = $this->note;
        $sheerUpload->release_date = $this->release_date;

        foreach (Uploads::JSON_PARAMS as $field => $label) {
            $sheerUpload->setJsonParam($field, $this->$field);
        }

        if (!$this->isEditForm()) {

            $sheerUpload->user_id = $this->user_id
                ? $this->user_id
                : \Yii::$app->user->getId();
            $sheerUpload->created = date('Y-m-d H:i:s');
            $sheerUpload->status = Uploads::STATUS_WAITING_VIDEO;
            $sheerUpload->file_size = 0;

        }

        if (!$sheerUpload->save()) {
            throw new \Exception("Cant save upload to db " . json_encode($sheerUpload->getErrors()));
        }

        $this->sheerUploadId = $sheerUpload->upload_id;
        $this->lastUpload = $sheerUpload;

        return true;
    }

    public function isEditForm()
    {
        return $this->sheerUploadId !== false;
    }

    /**
     * @return Uploads
     */
    public function getSheerUpload()
    {
        return UploadsQuery::model()
            ->filterByUploadId($this->sheerUploadId)
            ->limit(1)
            ->one();
    }

    public function rules()
    {
        $rules = [
            [
                [
                    'license_type',
                ],
                'required',
            ],
            [['license_type', 'note', 'release_date'], 'string'],
            [
                ['exclusive_rights_cost', 'ppv_cost'],
                'integer',
            ],
        ];

        if ($this->validateJsonFields) {
            $rules[] = [
                [
                    Uploads::JSON_TITLE,
                    Uploads::JSON_DESCRIPTION,
                    Uploads::JSON_GENRE,
                ],
                'required',
            ];
        }

        return $rules;
    }

    public function getTabName()
    {
        if ($this->isEditForm()) {
            return "Edit upload #" . $this->sheerUploadId;
        }
        return "New upload";
    }

    public function isWaitingForVideo()
    {
        return $this->getSheerUpload()->isStatusWaitingForVideo();
    }

    /**
     * @return int|bool
     */
    public function getSheerUploadId()
    {
        return $this->sheerUploadId;
    }

    /**
     * @return Uploads
     */
    public function getLastUpload(): Uploads
    {
        return $this->lastUpload;
    }

}