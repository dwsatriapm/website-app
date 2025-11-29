<?php 
require_once('db_connect.php');
require_once('_header.php') ?>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<div id="about" class="main-content">
   <div class="container">
      <div class="baris">
         <div class="col mt-2">
            <div class="card">
               <div class="card-body">
                  <div class="card-flex-column">
                     <div class="about_header" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                        <img src="<?= url('/assets/img/logo/logo.png') ?>" alt="Logo Luandry Kami" width="220">
                        <hr>
                        <br>
                        <h2>- Foto Owner Laundry Kami -</h2>
                        <img src="<?= url('/assets/img/owner.jpg') ?>" alt="Foto Laundry" class="about-photo">
                        <p>Berawal dari empat mahasiswa <b>STMIK IKMI Cirebon</b>, berakhir menjadi pemilik usaha laundry terbesar sedunia, siapa sangka tumpukan tugas bisa menginspirasi tumpukan cucian?</p>
                     </div>
                     <div class="about_us" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200">
                        <h2>- Tentang Kami -</h2>
                        <p>Kami merupakan mahasiswa aktif di <b>STMIK IKMI Cirebon</b> yang saat ini sedang menempuh studi di jurusan Teknik Informatika, dan ini merupakan project tugas akhir untuk mata kuliah Pemrograman Web Dasar semester 3</p>
                     </div>
                     <div class="team_list" style="margin-top:20px;" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="300">
                        <h2>- Anggota Kelompok -</h2>
                        <ul style="list-style: none; padding-left: 0; margin-top:10px;">
                           <li style="padding:6px 0; font-weight: bold;">1. Dwi Satria Pramudya (41246872)</li>
                           <li style="padding:6px 0; font-weight: bold;">2. Adimas Rifqi Nugraha (41246831)</li>
                           <li style="padding:6px 0; font-weight: bold;">3. Ahmad Nabila (41246834)</li>
                           <li style="padding:6px 0; font-weight: bold;">4. Ilham Ismail Faqih (41246904)</li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
   AOS.init();
</script>

</body>

</html>