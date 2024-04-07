<?php

session_start();
include_once 'header.php';
include_once '../connection/connect.php';
  

?>

<section class="container-xl mt-5">
            <ul class="navbar-nav d-flex flex-row text-secondary hover">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link me-4" aria-expanded="false">About</a>
                   
                </li>
                <li class="nav-item">
                    <a href="works.php" class="nav-link me-4" aria-expanded="false">Works</a>
    
                </li>
                <li class="nav-item">
                    <a href="skills.php" class="nav-link me-4" aria-expanded="false">Skills</a>
                    
                </li>
            </ul>
            <button type="button" class="btn btn-outline-info btn-sm my-4" data-bs-toggle="modal" data-bs-target="#exampleModal"
            ><i class="bi bi-plus"></i>Add New</button>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Add new about yourself</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="POST" action="#">
                        <div class="mb-3">
                          <label for="firstname" class="col-form-label">First Name:</label>
                          <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            <input type="text" class="form-control" id="firstname" name="firstname">
                          </div>
                          
                        </div>
                        <div class="mb-3">
                          <label for="lastname" class="col-form-label">Last Name:</label>
                          <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            <input type="text" class="form-control" id="lastname" name="lastname">
                          </div>
                        </div>
                        <div class="mb-3">
                          <label for="position" class="col-form-label">Position:</label>
                          <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person-workspace"></i>
                            </span>
                            <input type="text" class="form-control" id="position" name="position">
                          </div>
                         
                        </div>
                        <div class="mb-3">
                          <label for="Description" class="col-form-label">Description:</label>
                          <textarea class="form-control" id="Description" name="description"></textarea>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            <div class="container-xl border-top">
              <div class="wrap-detail">
                <div class="work-container">
                    <div class="works">
                        <div class="card">
                            <img src="../images/E-commerce.jpg" alt="">
                            <h4>Capstone Project <span>2020</span></h4>
                            <p>Deep-well Water Source Mapping: Web-based Application</p>
                            <div class="button">
                                <button class="greenBtn">Edit</button>
                                <button class="redBtn">Delete</button>
                            </div>
                        </div>

                        <div class="card">
                            <img src="../images/water supply.png" alt="">
                            <h4>Capstone Project <span>2020</span></h4>
                            <p>Deep-well Water Source Mapping: Web-based Application</p>
                            <div class="button">
                                <button class="greenBtn">Edit</button>
                                <button class="redBtn">Delete</button>
                            </div>
                        </div>
                        <div class="card">
                            <img src="../images/water supply.png" alt="">
                            <h4>Capstone Project <span>2020</span></h4>
                            <p>Deep-well Water Source Mapping: Web-based Application</p>
                            <div class="button">
                                <button class="greenBtn">Edit</button>
                                <button class="redBtn">Delete</button>
                            </div>
                        </div>
                        <div class="card">
                            <img src="../images/water supply.png" alt="">
                            <h4>Capstone Project <span>2020</span></h4>
                            <p>Deep-well Water Source Mapping: Web-based Application</p>
                            <div class="button">
                                <button class="greenBtn">Edit</button>
                                <button class="redBtn">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

<?php
include_once 'footer.php';
?>