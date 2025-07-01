<template>
  <div id="app" class="container">
    <header class="header">
      <h1 class="header_text">Трекер привычек</h1>
    </header>

    <main class="p-4">
      <router-view />
    </main>
  </div>
</template>

<script>
export default {
  name: 'App',
}
</script>

<style>
body {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Libertinus Math", system-ui;
  background: #FFF4ED;
}
.container{
  padding: 50px 5%;
}

.header {
  padding: 30px 20px;
  text-align: center;
}
.header h1 {
  position: relative;
  color: #398ebb; 
  display: inline-block;
  border-top: 2px solid;
  border-bottom: 2px solid;
  font-size: 3em;
  padding: 11px 60px;
  margin: 0; 
  line-height: 1;
}
.header h1:before, .header h1:after {
  content: ""; 
  position: absolute;
  top: 0;
  width: 30px;
  height: 100%;
  border-left: 2px solid;
  border-right: 2px solid;
  background: repeating-linear-gradient(180deg, transparent, transparent 2px, #3CA1D9 2px, #3CA1D9 4px);
}
.header h1:before {left: 0;}
header h1:after {right: 0;}
@media (max-width: 420px) {
  .header h1 {font-size: 2em;}
}
</style>
