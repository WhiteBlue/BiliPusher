<?php

try {
    while (true) {
        sleep(10);
        $conn = new MongoClient();
        $db = $conn->selectDB('bilibili');
        $collection = new MongoCollection($db, 'videos');
        $cursor = $collection->find()->sort(array('aid' => -1))->limit(500);;
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><document />');
        $xml->addchild("webSite", "v.dingxiaoyue.com");
        $xml->addchild("webMaster", "wsc449@qq.com");
        $xml->addchild("updatePeri", "60");
        foreach ($cursor as $doc) {
            $item = $xml->addchild("item");
            $item->addchild("op", "add");
            $item->addchild("title", $doc["title"]);
            $item->addchild("category", $doc["typename"]);
            $item->addchild("playLink", 'http://v.dingxiaoyue.com/view/' . $doc["aid"]);
            $item->addchild("imageLink", $doc["pic"]);
            $item->addchild("comment", $doc["description"]);

            $item->addchild("pubDate", $doc["created_at"]);
        }
        $xml->asXml("public/video.xml");
        echo 'ok';
        sleep(1200);
    }
} catch (\Exception $e) {
    dd($e);
}

