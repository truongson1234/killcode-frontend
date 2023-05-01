<template>
  <div>
    <div class="under-space"></div>
    <div class="footer-dark">
      <footer>
        <div class="container">
          <div class="row">
            <div class="col-sm-6 col-md-3 item">
              <h3>Tài nguyên</h3>
              <ul>
                <li class="pb-2 hover:text-black"><router-link :to="{ name: 'TagsList'}">Chủ đề</router-link></li>
                <li class="pb-2 hover:text-black"><router-link :to="{ name: 'PostsList'}">Bài viết</router-link></li>
                <li class="pb-2 hover:text-black"><router-link :to="{ name: 'QuestionsList'}">Câu hỏi</router-link></li>
                <li class="pb-2 hover:text-black"><router-link :to="{ name: 'Search'}">Tìm kiếm</router-link></li>
              </ul>
            </div>
            <div class="col-sm-6 col-md-3 item">
              <h3>Liên hệ</h3>
              <ul>
                <li class="text-gray-400">SĐT: 0123456789</li>
                <li class="text-gray-400">Địa chỉ: Cao đẳng Công nghệ cao Hà Nội - HHT</li>
              </ul>
            </div>
            <div class="col-md-6 item text">
              <h3>Giới thiệu</h3>
              <p>
                Trang web chia sẻ kiến thức lập trình của chúng tôi là một nơi tuyệt vời để học hỏi, chia sẻ và khám phá các kiến thức về lập trình. Chúng tôi cung cấp các bài hướng dẫn, các bài viết chia sẻ kinh nghiệm, các câu hỏi thường gặp và các tài liệu hữu ích khác trong lĩnh vực lập trình. Trang web của chúng tôi sẽ giúp bạn phát triển kỹ năng lập trình và cập nhật các xu hướng mới nhất trong ngành. Chúng tôi hy vọng trang web của chúng tôi sẽ giúp bạn trở thành một lập trình viên thành thạo và chuyên nghiệp.
              </p>
            </div>
            <div class="col item social">
              <a href="#"><i class='bx bxl-facebook'></i></a
              ><a href="#"><i class='bx bxl-twitter' ></i></a
              ><a href="#"><i class='bx bxl-github' ></i></a
              ><a href="#"><i class='bx bxl-instagram' ></i></a>
            </div>
          </div>
          <p class="copyright">KILLCODE © 2023</p>
        </div>
      </footer>
    </div>
  </div>
</template>

<script setup></script>

<style>
.under-space{
  padding-top: 3rem;
  /* background: #dee1e2; */
}
.footer-dark {
  padding:50px 0;
  color:var(--color-dark-mode);
  background-color:var(--color-light-mode);
}

.footer-dark h3 {
  margin-top:0;
  margin-bottom:12px;
  font-weight:bold;
  font-size:16px;
}

.footer-dark ul {
  padding:0;
  list-style:none;
  line-height:1.6;
  font-size:14px;
  margin-bottom:0;
}

.footer-dark ul a {
  color:inherit;
  text-decoration:none;
  opacity:0.6;
}

.footer-dark ul a:hover {
  opacity:0.8;
}

@media (max-width:767px) {
  .footer-dark .item:not(.social) {
    text-align:center;
    padding-bottom:20px;
  }
}

.footer-dark .item.text {
  margin-bottom:36px;
}

@media (max-width:767px) {
  .footer-dark .item.text {
    margin-bottom:0;
  }
}

.footer-dark .item.text p {
  opacity:0.6;
  margin-bottom:0;
}

.footer-dark .item.social {
  text-align:center;
}

@media (max-width:991px) {
  .footer-dark .item.social {
    text-align:center;
    margin-top:20px;
  }
}

.footer-dark .item.social > a {
  font-size:20px;
  width:36px;
  height:36px;
  line-height:36px;
  display:inline-block;
  text-align:center;
  border-radius:50%;
  box-shadow:0 0 0 1px rgba(255,255,255,0.4);
  margin:0 8px;
  color:var(--color-dark-mode);
  opacity:0.75;
}

.footer-dark .item.social > a:hover {
  opacity:0.9;
}

.footer-dark .copyright {
  text-align:center;
  padding-top:24px;
  opacity:0.3;
  font-size:13px;
  margin-bottom:0;
}
</style>
