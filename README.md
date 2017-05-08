# utbildninghosbois
.css ändringar
ändringar för att få sticky navigering och scroll to id offset rätt

/*Ändrar på knappens position i kontakt-"lådan"*/

.so-widget-sow-cta-default-b4812afd2ab9 .sow-cta-base .so-widget-sow-button {
  clear: both;
  position: inherit;
  width: 100%;
  font-weight: 900;
}

/*rundar kanterna på kontakt-"lådan"*/

.sow-cta-base {
  border-radius: 10px;
}

/*manuellt kodad .CSS
av Deciée Backman*/

/*för att menyns ska bli klistrad överst*/

#header.header {
  position: fixed;
  margin-top: 35px;
  height: 90px;
  background-color: #f4f4f4;
  z-index: 2;
}

#main.main .container {
  margin-top: 130px;
}

#menu-main.menu-main {
  position: inherit;
  float:initial;
  width: 100%;
  
}

/*top menyns beteende också klistrad*/
#topbar.topbar {
  position: fixed;
  background-color: #ffffff;
  margin: 0px;
  padding: 0px;
  width: 100%;
  z-index: 3;
}