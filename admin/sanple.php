<?php

			//if form has been submitted process it
			if (isset($_POST['submit'])) {
				extract($_POST);
				// if ($name == '') {
				// 	$error[] = 'Please enter the name.';
				// }
				var_dump($_POST);


				// if (!isset($error)) {
				// try {
				echo ("hello3");
				// if (isset($_FILES["file"]["name"])) {

				$file = $_FILES['display_pic'];
				$fileName = $_FILES['display_pic']['name'];  // extract the name of the uploaded file
				$fileSize = $_FILES['display_pic']['size'];
				$fileError = $_FILES['display_pic']['error'];
				$fileType = $_FILES['display_pic']['type'];
				$fileExt = explode('.', $fileName); // split the name of the file in .
				$fileActualExt = strtolower(end($fileExt));
				$fileNameNew = str_replace(' ', '', $name) . "." . $fileActualExt;
				$allowed = array('jpeg', 'jpg');
				echo ("hello২");

				if (in_array($fileActualExt, $allowed)) {
					if ($fileError === 0) {
						echo ("success");
						$fileLocation = $_SERVER['DOCUMENT_ROOT'] . '/uploads/crazyGuitars/' . $fileNameNew;
						echo ("location : ");
						echo ($fileLocation);
						if (move_uploaded_file($_FILES['display_pic']['tmp_name'], $fileLocation)) {
							$stmt = $db->prepare('INSERT INTO crazyguitar_members (name,designation,email,about, disply_pic) VALUES (:name, :designation,:email,:about, :display_pic)');
							$stmt->execute(array(
								':name' => $name,
								':designation' => $designation,
								':email' => $email,
								':about' => $about,
								':display_pic' => $fileNameNew
							));
						} else {
							echo ("File upload fail");
						}

						// header('Location: users.php?action=added');
						exit;
					} else {
						echo ("File upload fail error found");
					}
				} else {
					echo 'please choose a file';
				}
				// } catch (PDOException $e) {
				// 	echo $e->getMessage();
				// }
			}
			// }
			//check for any errors
			if (isset($error)) {
				foreach ($error as $error) {
					echo '<p class="error">' . $error . '</p>';
				}
			}
