<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Lamari\GridLBundle\Model;

class JqEvent {

    //protected $onSelectRow = "function(){jQuery('#ed1').attr('disabled', false);selected = id;}";
    protected $handler;
    protected $eventName;
    protected $eventHandler;
    public function __construct($event, $handler) {
        $this->eventName = $event;
        $this->eventHandler = $handler;
    }
    public function getOnSelectRow() {
        return $this->onSelectRow;
    }
    public function getEventName() {
        return $this->eventName;
    }
    public function getEventHandler() {
        return $this->eventHandler;
    }
    public function setEventName($eventName) {
        $this->eventName = $eventName;
    }
    public function setEventHandler($eventHandler) {
        $this->eventHandler = $eventHandler;
    }
}
