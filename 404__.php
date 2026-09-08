<?php

 /* Template Name: Test Page (Front) 
 */ 


get_header();


?>


	<main class="kmnd-main">


		<div class="container">
		
<style>
.error-container {
  display: flex;
  max-width: 755px;
  flex-direction: column;
  margin: 0 auto;
}

.error-heading {
  color: #ee7324;
  text-align: center;
  text-transform: capitalize;
  width: 100%;
  font: 800 270px/133.2% Manrope, sans-serif;
  margin-bottom: 0px;
  margin-top: 120px;
}

.error-content {
  display: flex;
  margin-top: 15px;
  width: 100%;
  padding-left: 17px;
  flex-direction: column;
  align-items: center;
  color: #242331;
}

.error-message {
  text-align: center;
  text-transform: lowercase;
  align-self: stretch;
  font: 700 50px/67px Manrope, sans-serif;
}

.error-code {
  margin-top: 21px;
  text-align: center;
  justify-content: center;
  font: 500 20px/160% Manrope, sans-serif;
}

.home-button {
  justify-content: center;
  border-radius: 42.9px;
  background: linear-gradient(90deg, #f6b34e 0%, #f38338 99.91%);
  margin-top: 42px;
  color: #fff;
  padding: 10px 25px;
    font: 600 18px Manrope, sans-serif;
    border: none;
    cursor: pointer;
    text-decoration: none;
    height: 44px;
    font-size: 18px;
    font-weight: 600;
    text-align: center;
}

@media (max-width: 991px) {
  .error-heading {
    max-width: 100%;
    font-size: 40px;
  }

  .error-content {
    max-width: 100%;
  }

  .error-message {
    max-width: 100%;
    font-size: 40px;
    line-height: 60px;
  }

  .home-button {
    margin-top: 40px;
    padding: 10px 20px;
  }
}


/*******************************/
/**********************/

.webinar-container {
	margin-top: 150px;
  border-radius: 33px;
  background: linear-gradient(108deg, #f38338 15.95%, #f6b34e 100%);
  padding: 47px 64px;
      margin-bottom: 50px;
}

@media (max-width: 991px) {
  .webinar-container {
    padding: 20px 25px;
  }
  .webinar-image {
    width: 100%;
  }
}

.banner__wrapper {
  display: flex;
  gap: 60px;
  align-items: center;
}

@media (max-width: 991px) {
  .banner__wrapper {
    flex-direction: column;
    align-items: stretch;
    gap: 0;
  }
}

.main-content {
/*   display: flex;
  flex-direction: column;
  width: 63%; */
}

@media (max-width: 991px) {
  .main-content {
    width: 100%;
  }
}

.webinar-card {
  border-radius: 12px;
  box-shadow: 0 12px 24px -6px rgba(24, 26, 42, 0.12);
  border: 1px solid rgba(232, 232, 234, 1);
  background-color: #fff;
  flex-grow: 1;
  width: 100%;
  padding: 20px 23px;
}

@media (max-width: 991px) {
  .webinar-card {
    max-width: 100%;
    margin-top: 40px;
    padding-left: 20px;
  }
}

.card-content {
  display: flex;
  gap: 20px;
}

@media (max-width: 991px) {
  .card-content {
    flex-direction: column;
    align-items: stretch;
    gap: 0;
  }
}

.card-text {
  display: flex;
  flex-direction: column;
  width: 71%;
}

@media (max-width: 991px) {
  .card-text {
    width: 100%;
  }
}

.banner_content {
  display: flex;
  flex-direction: column;
  align-self: stretch;
  font: 500 18px Manrope, sans-serif;
  color: #242331;
  margin: auto 0;
}

@media (max-width: 991px) {
  .banner_content {
    max-width: 100%;
    margin-top: 33px;
  }
}

.webinar-date {
    font-family: Manrope;
    font-size: 18px;
    font-weight: 500;
    line-height: 24px;
    text-align: left;
    color: #242331;
	line-height: 133%;
}


@media (max-width: 991px) {
  .webinar-date {
    max-width: 100%;
  }
}

.webinar-title {
  margin-top: 30px;
  font: 400 27px/40px Manrope, sans-serif;
}

@media (max-width: 991px) {
  .webinar-title {
    max-width: 100%;
  }
}

.read-more {
  align-self: start;
  display: flex;
  margin-top: 30px;
  gap: 11px;
  text-transform: capitalize;
  line-height: 160%;
}

@media (max-width: 991px) {
  .read-more {
    margin-top: 40px;
  }
}

.read-more-text {
  font-family: Manrope, sans-serif;
  flex-grow: 1;
}

.arrow-icon {
  aspect-ratio: 1.69;
  width: 17px;
  stroke-width: 2px;
  stroke: #303030;
  margin: auto 0;
}

.card-image {
  width: 29%;
}

@media (max-width: 991px) {
  .card-image {
    width: 100%;
  }
}

.webinar-image {
  aspect-ratio: 0.98;
  width: 188px;
  max-width: 100%;
  border-radius: 8px;
  flex-grow: 1;
}

@media (max-width: 991px) {
  .webinar-image {
    margin-top: 27px;
  }
}

.sidebar {
  width: 37%;
}

@media (max-width: 991px) {
  .sidebar {
    width: 100%;
  }
}

.sidebar-content {
  display: flex;
  margin-top: 10px;
  flex-grow: 1;
  flex-direction: column;
  color: #fff;
  font-weight: 600;
}

@media (max-width: 991px) {
  .sidebar-content {
    margin-top: 40px;
  }
}

.sidebar-title {
  font: 50px/110% Manrope, sans-serif;
  font-family: Manrope;
	font-size: 50px;
	font-weight: 600;
	line-height: 55px;
	text-align: left;

}

@media (max-width: 991px) {
  .sidebar-title {
    font-size: 40px;
  }
}

.sidebar-description {
  margin-top: 19px;
  font: 800 22px/29px Manrope, sans-serif;
}

.cta__button {
  justify-content: center;
  border-radius: 42.9px;
  border: 4px solid #f6b34e;
  background-color: #fff;
  align-self: start;
	margin-top: 26px;
    color: #ee7324;
    padding: 5px 28px;
    font: 18px Manrope, sans-serif;
    text-decoration: none;
    max-height: 44px;
    height: 44px;
}

@media (max-width: 991px) {
  .cta__button {
    padding: 0 20px;
  }
}

.visually-hidden {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}

</style>



<section class="error-container">


  <h1 class="error-heading">Oops!</h1>
  <div class="error-content">
    <p class="error-message">We <span>can't seem to find the page you're looking for</span></p>
    <p class="error-code">Error code: 404</p>
    <a href="/" class="home-button" tabindex="0">Go back home</a>
  </div>
  
</section>




<!----------------------------------------->

			
		
<section class="webinar-container">
  <div class="banner__wrapper">
    <div class="main-content">
      <article class="webinar-card">
        <div class="card-content">
          <div class="card-text">
            <div class="banner_content">
              <p class="webinar-date">January 18, 2024</p>
              <h3 class="webinar-title">Isla x HTN Webinar - Innovative new community healthcare models</h3>
              <div class="read-more">
                <span class="read-more-text">Read More</span>
                
				
				<img loading="lazy" src="<?= get_stylesheet_directory_uri(); ?>/assets/images/arrow.svg" alt="" class="arrow-icon" />
				
				
              </div>
            </div>
          </div>
          <div class="card-image">
            <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/5a856bd48eef1d3f748b2c92d2b0a26aedd71674565443744e2c8c1907121804?apiKey=a6ae6c1d8d6448a48b14a4a0097d1701&" alt="Webinar illustration" class="webinar-image" />
          </div>
        </div>
      </article>
    </div>
    <div class="sidebar">
      <div class="sidebar-content">
        <h3 class="sidebar-title">Get inspired</h3>
        <p class="sidebar-description">Check out the latest news, events, trends, insights, and product highlights from Isla, plus a whole lot more!</p>
        <a href="#" class="cta__button" role="button">Find out more</a>
      </div>
    </div>
  </div>
</section>
		
		
		
		<!----------------------------------------->

		
		</div>


	</main><!-- #main -->
<?php

get_footer();