<?php
namespace framework\resources;

use yii\base\Component;

/**
 * Created by PhpStorm.
 * User: henryzhu
 * Date: 16-7-26
 * Time: 下午2:29
 * Email: henryzxj1989@gmail.com
 */

/**
 * Class ApiAbstract
 * @package framework\resources
 */
abstract class ApiAbstract extends Component implements ApiInterface
{
    /**新增
     * @var \service\message\common\Header
     */
    private $_header;

    /**新增
     * @var \framework\Request
     */
    private $_request;


    /**修改
     * @return mixed
     */
    public function getTraceId()
    {
        return $this->_header->getTraceId();
    }

    /**新增
     * @param $header
     * @return $this
     */
    public function setHeader($header)
    {
        $this->_header = $header;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isRemote()
    {
        return $this->_request->isRemote();
    }

    /**新增
     * @param $request
     * @return $this
     */
    public function setRequest($request)
    {
        $this->_request = $request;
        return $this;
    }

    public function isDebug()
    {
        return $this->_request->isDebug();
    }

    public function getLevel()
    {
        return $this->_request->getLevel();
    }

    /**新增
     * @return $this
     */
    public function getSource()
    {
        return $this->_header->getSource();
    }

    /**
     * @return string
     */
    public function getAppVersion(){
        return $this->_header->getAppVersion();
    }

}