<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign in & Sign up Form</title>
    <link
      rel="stylesheet"
      href="{{asset("css/bootsrap.min.css")}}"
    />
    <link
      rel="stylesheet"
      href="{{asset("css/login.css")}}"
    />
  </head>
  <body>
    <main>
      <div class="box">
        <div class="inner-box">
          <div class="forms-wrap">
            <form
              action="{{ route('login') }}"
              autocomplete="off"
              class="sign-in-form"
              method="post"
            >
            @csrf
              <div class="logo">
                <img src="{{asset("img/ICON SIGMA.png")}}" alt="SIGMA" />
                <h4>SIGMA</h4>
              </div>

              <div class="heading">
                <h2>Welcome Back</h2>
                {{-- <h6>Not registred yet?</h6>
                <a href="#" class="toggle">Sign up</a> --}}
              </div>

              <div class="actual-form">
                <div class="input-wrap">
                  <input
                    type="text"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    name="email"
                    required
                  />
                  <label>Email</label>
                </div>

                <div class="input-wrap">
                  <input
                    type="password"
                    name="password"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    required
                  />
                  <label>Password</label>
                </div>

                <input type="submit" value="Sign In" class="sign-btn" />

                {{-- <p class="text">
                  Forgotten your password or you login datails?
                  <a href="#">Get help</a> signing in
                </p> --}}
              </div>
            </form>

            <form
              action="/register"
              autocomplete="off"
              class="sign-up-form"
              method="post"
            >
              <div class="logo">
                <img src="{{asset("img/ICON SIGMA.png")}}" alt="SIGMA" />
                <h4>SIGMA</h4>
              </div>

              <div class="heading">
                <h2>Get Started</h2>
                <h6>Already have an account?</h6>
                <a href="#" class="toggle">Sign in</a>
              </div>

              <div class="actual-form">
                <div class="input-wrap">
                  <input
                    name="username"
                    type="text"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    required
                  />
                  <label>Name</label>
                </div>
                <div class="input-wrap">
                  <input
                    type="password"
                    name="password"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    required
                  />
                  <label>Password</label>
                </div>

                <div class="input-wrap">
                  <input
                    type="number"
                    name="no_telp"
                    class="input-field"
                    autocomplete="off"
                    required
                  />
                  <label>No Telpon</label>
                </div>
                <div class="input-wrap">
                  <select
                    class="form-select"
                    aria-label="Default select example"
                    name="id_lokasi" 
                  >
                    <option selected>Pilih Lokasimu:</option>
                    
                  </select>
                </div>

                <input type="submit" value="Sign Up" class="sign-btn" />

                <p class="text">
                  By signing up, I agree to the
                  <a href="#">Terms of Services</a> and
                  <a href="#">Privacy Policy</a>
                </p>
              </div>
            </form>
          </div>

          <div class="carousel">
            <div class="images-wrapper">
              <img
                src="{{asset("img/kids1.png")}}"
                class="image img-1 show"
                alt=""
              />
              <img src="{{asset("img/kids2.png")}}" class="image img-2" alt="" />
              <img src="{{asset("img/kids3.png")}}" class="image img-3" alt="" />
            </div>

            <div class="text-slider">
              <div class="text-wrap">
                <div class="text-group">
                  <h2>Create your own courses</h2>
                  <h2>Customize as you like</h2>
                  <h2>Invite students to your class</h2>
                </div>
              </div>

              <div class="bullets">
                <span class="active" data-value="1"></span>
                <span data-value="2"></span>
                <span data-value="3"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Javascript file -->

    <script src="{{asset("js/login.js")}}"></script>
  </body>
</html>
