<?php



namespace App;

use App\DB;


class Book
{

  public function  createNewBook()
  {

    // Todo: CRUD
    if (isset($_POST['addNewBookBtn'])) {
      $task  = $_POST['bookInput'];
      $date = date('Y-m-d H:i:s');
      $insertStatement = "INSERT INTO `to_do_list` VALUES(NULL,?,0,?,?)";
      $myDBObj = new DB();
      $queryObj = $myDBObj->Connection->prepare($insertStatement);
      $queryObj->bind_param('sis', $task, $_SESSION['userID'], $date);
      $queryObj->execute();
    }
  }

  public function getMyBooks()
  {
    $selectStatement = 'SELECT * FROM  `to_do_list` WHERE user_id = ? AND Date(date) = ?';
    $date = date('Y-m-d');
    $myDBObj = new DB();
    $queryStmtObj = $myDBObj->Connection->prepare($selectStatement);
    $queryStmtObj->bind_param('is', $_SESSION['userID'], $date);
    $queryStmtObj->execute();
    return $queryStmtObj->get_result();
  }

  public function getBookById($bookId)
  {
    $selectStatement = 'SELECT * FROM `to_do_list` WHERE id = ?';
    $myDBObject = new \App\DB();
    $queryStmtObject = $myDBObject->Connection->prepare($selectStatement);
    $queryStmtObject->bind_param('i', $bookId);
    $queryStmtObject->execute();
    return ($queryStmtObject->get_result())->fetch_assoc();
  }

  public function updateBook($bookId)
  {
    if (isset($_POST['updateBookBtn'])) {
      $updatedBook = $_POST['bookInput'];
      $updateStatement = 'UPDATE `to_do_list` SET note = ? WHERE id = ?';
      $myDBObject = new \App\DB();
      $queryStmtObject = $myDBObject->Connection->prepare($updateStatement);
      $queryStmtObject->bind_param('si', $updatedBook, $bookId);
      $queryStmtObject->execute();
    }
  }

  public function deleteBook()
  {
    if (isset($_GET['bookToDelete'])) {
      $bookId = $_GET['bookToDelete'];
      $deleteStatement = 'DELETE FROM `to_do_list` WHERE id = ?';
      $myDBObject = new \App\DB();
      $queryStmtObject = $myDBObject->Connection->prepare($deleteStatement);
      $queryStmtObject->bind_param('i', $bookId);
      $queryStmtObject->execute();
    }
  }
}
