<?php

 /* Template Name: Contact Page (Front) 
 */ 



get_header();

?>

	<main class="kmnd-main">


		<div class="container">

	<!------------------------------->


<style>
.contact-section {
  display: flex;
  gap: 20px;
  margin-top: 150px;
}

@media (max-width: 991px) {
  .contact-section {
    flex-direction: column;
    align-items: stretch;
    gap: 0;
	margin-top: 50px;
  }
}

.contact-info {
  display: flex;
  flex-direction: column;
  line-height: normal;
  width: 38%;
  margin-left: 0;
}

@media (max-width: 991px) {
  .contact-info {
    width: 100%;
  }
}

.contact-content {
  display: flex;
  flex-direction: column;
  justify-content: center;
}

@media (max-width: 991px) {
  .contact-content {
    max-width: 100%;
    margin-top: 40px;
  }
}

.contact-text {
  display: flex;
  flex-direction: column;
  color: #242331;
}

@media (max-width: 991px) {
  .contact-text {
    max-width: 100%;
  }
}

.contact-heading {
  font: 600 50px/61px Manrope, sans-serif;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

@media (max-width: 991px) {
  .contact-heading {
    max-width: 100%;
    font-size: 40px;
    line-height: 54px;
  }
}

.contact-description {
  margin-top: 18px;
  font: 500 18px/24px Manrope, sans-serif;
}

@media (max-width: 991px) {
  .contact-description {
    max-width: 100%;
  }
}

.contact-details {
  display: flex;
  margin-top: 40px;
  flex-direction: column;
}

@media (max-width: 991px) {
  .contact-details {
    max-width: 100%;
  }
}

.contact-item {
  display: flex;
  gap: 0;
}

@media (max-width: 991px) {
  .contact-item {
    flex-wrap: wrap;
  }
}

.icon-wrapper {
  align-items: center;
  border-radius: 10px;
  background: linear-gradient(90deg, #f6b34e 0%, #f38338 100%);
  display: flex;
  justify-content: center;
  width: 48px;
  height: 48px;
  padding: 14px;
}

.icon {
  aspect-ratio: 1;
  object-fit: auto;
  object-position: center;
  width: 20px;
}

.contact-info-text {
  color: #242331;
  justify-content: center;
  flex: 1;
  padding: 12px;
  padding-top: 0px;
  font: 500 18px/18px Manrope, sans-serif;
}

.contact-email {
  align-self: start;
  display: flex;
  margin-top: 24px;
  gap: 0;
}

.email-text {
  color: #242331;
  white-space: nowrap;
  justify-content: center;
  padding: 12px;
  font: 500 18px/151% Manrope, sans-serif;
}

@media (max-width: 991px) {
  .email-text {
    white-space: initial;
  }
}

.contact-image {
  display: flex;
  flex-direction: column;
  line-height: normal;
  width: 62%;
  margin-left: 20px;
}

@media (max-width: 991px) {
  .contact-image {
    width: 100%;
	margin-top: 40px;
    margin-left: 0px;
  }
}

.contact-illustration {
  aspect-ratio: 1.11;
  object-fit: auto;
  object-position: center;
  width: 100%;
  flex-grow: 1;
}

@media (max-width: 991px) {
  .contact-illustration {
    max-width: 100%;
    margin-top: 40px;
  }
}


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

<section class="contact-section">
  <div class="contact-info">
    <div class="contact-content">
      <div class="contact-text">
        <h2 class="contact-heading">
          Have questions?
          <br />
          Get in touch
        </h2>
        <p class="contact-description">
          For project support, please contact your technical programme manager or support@isla.health
          <br />
          <br />
          For all other requests please use the form
        </p>
      </div>
      <div class="contact-details">
        <div class="contact-item">
          <div class="icon-wrapper">
            <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/eb6ccca3f613ad772fb0e85a0f8b254d01ecbca497f35e250f7f994c1308a8fa?apiKey=a6ae6c1d8d6448a48b14a4a0097d1701&" class="icon" alt="" />
          </div>
          <p class="contact-info-text">
            Huckletree Shoreditch, Alphabeta Building,
            <br /><br />
            18 Finsbury Square, London, EC2A 1AH
          </p>
        </div>
        <div class="contact-email">
          <div class="icon-wrapper">
            <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/213e6a4760553f67e6308a2a039f44bc821002dfac345b8c5c61a29c3bada051?apiKey=a6ae6c1d8d6448a48b14a4a0097d1701&" class="icon" alt="" />
          </div>
          <p class="email-text">hello@isla.health</p>
        </div>
      </div>
    </div>
  </div>
  <div class="contact-image">
   
   
   <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/embed/v2.js"></script>
<script>
  hbspt.forms.create({
    region: "na1",
    portalId: "6100340",
    formId: "acf79b05-66aa-4ab4-aebb-cead4f8fcc25"
  });
</script>


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