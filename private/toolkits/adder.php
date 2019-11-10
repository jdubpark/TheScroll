<?php

  require_once __DIR__.'/../db/db.php';

  class Adder{
    private $pdo;

    function __construct($pdo){
      $this->pdo = $pdo;
    }

    private function do_exec($stmt){

    }

    function role($data){
      $params = ['name', 'iss', 'ara', 'ara_ns', 'ard', 'ard_ns', 'sta', 'sta_ns', 'roa', 'ros', 'hra', 'hrs', 'sea', 'sea_ns'];
      $bindVals = [];
      foreach ($params as $param){$bindVals[":$param"] = $data[$param];}
      $param = null;
      $query = 'INSERT INTO Roles (
        name, is_super,
        article_access, article_access_nonself, article_delete, article_delete_nonself,
        stat_access, stat_access_nonself,
        role_access, role_status,
        hr_access, hr_super,
        setting_access, setting_access_nonself
      ) VALUES (
        :name, :iss,
        :ara, :ara_ns, :ard, :ard_ns,
        :sta, :sta_ns,
        :roa, :ros,
        :hra, :hrs,
        :sea, :sea_ns
      );';
      $stmt = $this->pdo->prepare($query);
      if ($stmt->execute($bindVals)){
        return 'success';
      } else {
        return 'fail';
      }
    }

    function user($data){
      $params = ['email', 'namef', 'namel', 'namem', 'named', 'role'];
      $bindVals = [];
      foreach ($params as $param){$bindVals[":$param"] = $data[$param];}
      $param = null;
      $query = 'INSERT INTO Users (
        email,
        name_first, name_last, name_middle, name_display,
        role
      ) VALUES (
        :email,
        :namef, :namel, :namem, :named,
        :role
      );';
      $stmt = $this->pdo->prepare($query);
      if ($stmt->execute($bindVals)){
        return 'success';
      } else {
        return 'fail';
      }
    }

    function article($data){
      $paramsArticle = ['title', 'author', 'author_display', 'title', 'section', 'pubtime'];
      $bindArticle = [];
      // $sections = $data['section'];
      foreach ($paramsArticle as $param){$bindArticle[":$param"] = $data[$param];}
      // query
      $queryArticle = 'INSERT INTO ArticleT1 (
        title, author, author_display, section_id, time_published
      ) VALUES (
        :title, :author, :author_display, :section, :pubtime
      );';
      // $querySection = 'INSERT INTO SectionT1 (
      //   article_id, section_id
      // ) VALUES (?, ?)';
      // if (!is_array($sections)) $sections = [$sections];
      // for ($i = 1; $i < count(array_keys($sections)); $i++) $querySection .= ', (?, ?)';
      $sectionData = [];
      // $querySection .= ';';
      $querySummary = 'INSERT INTO SummaryT1 (article_id, summary) VALUES (?, ?);';
      $queryContent = 'INSERT INTO ContentT1 (article_id, content) VALUES (?, ?);';
      $queryImage = 'INSERT INTO ImageCoverT1 (article_id, link, caption) VALUES (?, ?, ?);';
      $queryVideo = 'INSERT INTO VideoCoverT1 (article_id, link, caption) VALUES (?, ?, ?);';
      // execute
      try {
        $this->pdo->beginTransaction();
        // metadata
        $stmt = $this->pdo->prepare($queryArticle);
        $stmt->execute($bindArticle);
        $articleID = $this->pdo->lastInsertId();
        // section
        // $stmt = $this->pdo->prepare($querySection);
        // foreach ($sections as $section){
        //   $sectionData[] = $articleID;
        //   $sectionData[] = $section;
        // }
        // $stmt->execute($sectionData);
        // summary
        $stmt = $this->pdo->prepare($querySummary);
        $stmt->execute([$articleID, $data['summary']]);
        // content
        $stmt = $this->pdo->prepare($queryContent);
        $stmt->execute([$articleID, $data['content']]);
        // cover image
        if (!empty($data['cover_image'])){
          $stmt = $this->pdo->prepare($queryImage);
          $stmt->execute([$articleID, $data['cover_image'], $data['cover_image_caption']]);
        }
        // cover video
        if (!empty($data['cover_video'])){
          $stmt = $this->pdo->prepare($queryVideo);
          $stmt->execute([$articleID, $data['cover_video'], $data['cover_video_caption']]);
        }
        // commit
        $this->pdo->commit();
        return 'success';
      } catch (Exception $e){
        // echo $e->getMessage();
        $this->pdo->rollBack();
        return 'fail';
      }
    }
  }

  $Adder = new Adder($pdo);

?>
