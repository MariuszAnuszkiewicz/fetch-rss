<?php namespace MariuszAnuszkiewicz\src\Fetch;

use MariuszAnuszkiewicz\src\Input\InputField;
use MariuszAnuszkiewicz\src\SaveStrategy\TypeSaved;
use MariuszAnuszkiewicz\src\SaveStrategy\SimpleSaveCsv;
use MariuszAnuszkiewicz\src\SaveStrategy\ExtendedSaveCsv;

class FetchData {

   private $_feeds, $_data = [];

   public function run($url, $status_view = "off") {

       if (InputField::load('submit') && !empty($url)) {
           if (preg_match_all('/^(http:\/\/feeds|https:\/\/feeds)/', $url)) {
               if (@simplexml_load_file($url)) {
                    $this->_feeds = simplexml_load_file($url);
                   if (!empty($this->_feeds)) {

                       foreach ($this->_feeds->channel->item as $item) {

                           $columns = ['title', 'description', 'link', 'pubDate', 'creator'];
                           list($title, $description, $link, $pubDate, $creator) = $columns;

                           $date = new \DateTime(trim($item->pubDate));
                           $pattern_ynd = '.Y-n-d';
                           $pattern_his = '-H:i:s';
                           $ynd_str = strstr($pattern_ynd, '.');
                           $Ynd = substr($ynd_str, 1) . "\t";
                           $his_str = strstr($pattern_his, '-');
                           $His = substr($his_str, 1);
                           $date_output = $date->format($Ynd .' '. $His);

                           $this->_data[] = $title;
                           $this->_data[] = $item->title;
                           $this->_data[] = $description;
                           $this->_data[] = $item->description;
                           $this->_data[] = $link;
                           $this->_data[] = $item->link;
                           $this->_data[] = $pubDate;
                           $this->_data[] = $date_output;
                           $this->_data[] = $creator;
                           $this->_data[] = $item->creator;

                       }
                       ?>
                        <div id="rss_content">
                       <?php
                           echo $status_view == "off" ? null : implode("<br>", $this->_data);
                       ?>
                        </div>
                       <?php

                       $simpleSave = new TypeSaved('simple', new SimpleSaveCsv);
                       $simple_run = $simpleSave->load();
                       $simple_run->run($this->_data);

                       $extendedSave = new TypeSaved('extended', new ExtendedSaveCsv);
                       $extended_run = $extendedSave->load();
                       $extended_run->run($this->_data);
                   }
               }
           }
           else {

               try {

                   $config = new \InvalidUrl();
                   $config->setStatus(true);
                   $config->checkUrl();

               } catch(\InvalidUrlException $e) {

                   echo $e->getMessage();

               }
           }
       }
   }
}

