<?php

include_once 'connection/connect.php';

$stmt = $conn->prepare("SELECT firstname, lastname, position, description FROM about");
$stmt->execute();
$result = $stmt->get_result();
$about = $result->fetch_assoc();

$stmt = $conn->prepare("SELECT title, year, description, image FROM projects");
$stmt->execute();
$projects = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stmt = $conn->prepare("SELECT skill_name, skill_img FROM skills");
$stmt->execute();
$skills = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Quicksand:wght@300..700&family=Roboto+Slab:wght@100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="assets/style.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="wrapper">
        <nav class="circle">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </nav>
        <div class="container">
            <div class="my-name">
                <h1 data-aos="fade-right" data-aos-duration="1500"><?php echo htmlspecialchars($about['firstname']); ?></h1>
                <h1 data-aos="fade-right" data-aos-duration="1500"><?php echo htmlspecialchars($about['lastname']); ?></h1>
            </div>
            <div class="wrap">
                <div class="profession" data-aos="fade-right" data-aos-duration="1500">
                    <h1><?php echo htmlspecialchars($about['position']); ?></h1>
                    <span class="lines"></span>
                    <p>
                        <?php echo htmlspecialchars($about['description']); ?>
                    </p>
                </div>

                <ul class="nav-links" data-aos="fade-left" data-aos-duration="1500">
                    <li><a href="#about">About</a></li>
                    <li><a href="#skills">Skills</a></li>
                    <li><a href="#projects">Projects</a></li>
                </ul>

            </div>
        </div>
    </div>

    <section>
        <div class="container">
            <div class="title" data-aos="fade-up" data-aos-duration="2000">
                <h1 id="projects">Projects</h1>
                <span class="line"></span>
            </div>

            <div class="mini-container">
                <?php foreach ($projects as $project) : ?>
                    <div class="rows" data-aos="fade-up" data-aos-duration="2000">
                        <img src="images/<?php echo htmlspecialchars($project['image']); ?>" alt="">
                        <h2 data-aos="fade-up" data-aos-duration="2000" data-aos-delay="200"><?php echo htmlspecialchars($project['title']); ?> <span><?php echo htmlspecialchars($project['year']); ?></span></h2>
                        <p data-aos="fade-up" data-aos-duration="2000" data-aos-delay="200"><?php echo htmlspecialchars($project['description']); ?></p>
                        <div class="button"><a href="#">Visit</a></div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <section>
        <div class="container">
            <div class="title" data-aos="fade-up" data-aos-duration="2000">
                <h1 id="skills">My Skills</h1>
                <span class="line"></span>
            </div>

            <div class="my-skills">
                <?php foreach ($skills as $skill) : ?>
                    <div class="skills" data-aos="fade-up" data-aos-duration="1000">
                        <img src="images/<?php echo htmlspecialchars($skill['skill_img']); ?>" alt="">
                        <p><?php echo htmlspecialchars($skill['skill_name']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="title">
                <h1 id="contact">Contact</h1>
                <span class="line"></span>
            </div>

            <div class="contact">
                <div class="contact-container">
                    <li class="contact-item">
                        <i class="fa-regular fa-envelope"></i>
                        <a href="mailto:annolmanggona12@gmail.com">annolmanggona12@gmail.com</a>
                    </li>
                    <p>&#169; 2024 Nur Manggona</p>
                    <p>All right reserved.</p>

                </div>


                <div class="contact-container">
                    <li><a href="https://www.facebook.com/Annol.manggona12"><i class="fa-brands fa-facebook"></i></a></li>
                    <li><a href=""><i class="fa-brands fa-instagram"></i></a></li>
                    <li><a href=""><i class="fa-brands fa-github"></i></a></li>
                    <li><a href=""><i class="fa-brands fa-tiktok"></i></a></li>
                </div>
            </div>
        </div>
    </section>


    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>