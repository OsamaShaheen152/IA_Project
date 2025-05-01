<?php

require_once('../vendor/autoload.php');

$authObj = new \App\Authenticate();
$authObj->redirectIfNotAuth();

$bookObject = new \App\Book();


$allBooks = $bookObject->getMyBooks();

$bookObject->deleteBook();


?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="\viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/index.css?v=<?php echo time() ?>">
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet'
    href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap'>
  <title>Books List</title>
</head>

<body>
  <?php require($_SERVER['DOCUMENT_ROOT'] . '/IA_SECTION_PROJECT/pages/Layout/Navbar.php') ?>

  <div class="mt-5">

    <table class="table table-dark container">
      <tr>
        <th>BOOK NAME</th>
        <th>Edit BOOK</th>
        <th>Delete BOOK</th>
      </tr>

      <?php foreach ($allBooks as $book): ?>
        <tr>
          <td>
            <?php echo $book['note'] ?>
          </td>

          <td>
            <a href="BookUpdate.php?bookId=<?php echo $book['id'] ?>">
              <button class="btn btn-warning text-center">Update</button>
            </a>
          </td>
          <td>
            <a href="?bookToDelete=<?php echo $book['id'] ?>">
              <button class="btn btn-danger text-center">Delete</button>
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
  <hr>


</body>

</html>