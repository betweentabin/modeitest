<template>
  <div class="home-page">
    <!-- Navigation -->
    <navigation />
    
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-image" :style="{ 'background-image': 'url(' + heroImage + ')' }">
        <div class="hero-overlay">
          <div class="hero-content">
            <div class="hero-title-wrapper">
              <h1 class="hero-title">{{ text66 }}</h1>
            </div>
            <div class="hero-subtitle-wrapper">
              <div class="hero-subtitle">{{ text67 }}</div>
            </div>
            <div class="hero-button-wrapper">
              <div class="hero-button-text">{{ text68 }}</div>
              <div class="hero-button-icon">
                <img
                  class="vector-2"
                  :src="vector35"
                  alt="Vector"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

      <div class="frame-1321317457">
          <div class="frame-1321317490" :style="{ 'background-image': 'url(' + frame13213174901 + ')' }">
            <div class="frame-1321317491">
              <div class="text-1 valign-text-middle inter-bold-white-15px">{{ text72 }}</div>
              <div class="seminar valign-text-middle inter-bold-white-24px">{{ seminar }}</div>
            </div>
          </div>
          <div class="frame-1321317491-1" :style="{ 'background-image': 'url(' + frame1321317491 + ')' }">
            <div class="frame-1321317491-2">
              <div class="text-1 valign-text-middle inter-bold-white-15px">{{ text69 }}</div>
              <div class="publications valign-text-middle inter-bold-white-24px">{{ publications1 }}</div>
            </div>
          </div>
          <div class="frame-1321317490-1" :style="{ 'background-image': 'url(' + frame13213174902 + ')' }">
            <div class="frame-1321317491-3">
              <div class="text-2 valign-text-middle inter-bold-white-16px">{{ text70 }}</div>
              <div class="infomation valign-text-middle inter-bold-white-24px">{{ infomation1 }}</div>
            </div>
          </div>
          <div class="frame-1321317492" :style="{ 'background-image': 'url(' + frame1321317492 + ')' }">
            <div class="frame-1321317491-4">
              <div class="text-2 valign-text-middle inter-bold-white-16px">{{ text71 }}</div>
              <div class="membership valign-text-middle inter-bold-white-24px">{{ membership }}</div>
            </div>
          </div>
        </div>
      
      
    
      <svg class="vector-13" viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M-8.02699e-08 120L-3.89972e-06 44.6076C413.287 -99.5267 685.476 162.131 1440 44.6077L1440 120L-8.02699e-08 120Z" fill="#ECECEC"/>
      </svg>
      <div class="overlap-group8">
        <div class="main">
          <div class="about">
            <div class="flex-col-1">
              <div class="text-47">{{ text112 }}</div>
              <div class="group-30">
                <img
                  class="vector-16"
                  :src="vector152"
                  alt="Vector 16"
                />
                <div class="for-you valign-text-middle">{{ forYou }}</div>
                <img
                  class="vector-15"
                  :src="vector152"
                  alt="Vector 15"
                />
              </div>
              <div class="text-48" v-html="text113"></div>
            </div>
          </div>
          <div class="frame-1321317462">
            <div class="frame-1321317456">
              <div class="frame-1321317482">
                <card :image="card1Props.image" :frame1321317481Props="card1Props.frame1321317481Props" />
                <card
                  :image="card2Props.image"
                  :className="card2Props.className"
                  :frame1321317481Props="card2Props.frame1321317481Props"
                />
                <card
                  :image="image1"
                  :frame1321317481Props="frame1321317481Props"
                />
              </div>
              <div class="button" @click="$router.push('/about-institute')" style="cursor: pointer;">
                <div class="text-55 valign-text-middle inter-bold-white-15px">{{ text120 }}</div>
                <frame13213176122 />
              </div>
            </div>
          </div>
          <div class="content-view">
            <div class="frame-1321317480">
              <div class="group-10">
                <div class="infomation-1 valign-text-middle inter-bold-black-48px">{{ infomation2 }}</div>
                <div class="flex-row">
                  <img
                    class="vector-6"
                    :src="vector63"
                    alt="Vector 6"
                  />
                  <div class="text-56 valign-text-middle inter-bold-black-24px">{{ text121 }}</div>
                </div>
              </div>
              <x-button3 />
            </div>
            <div class="frame-1321317467">
              <div class="frame-13213174">
                <div class="frame-13 news-item-clickable" @click="goToNewsDetail(0)">
                  <div class="date valign-text-middle inter-normal-sonic-silver-18px">{{ date1 }}</div>
                  <div :class="getCategoryClass(dynamicNewsItems[0])" class="category-badge">{{ getCategoryLabel(dynamicNewsItems[0]) }}</div>
                  <div class="hot-info valign-text-middle inter-normal-ship-gray-18px">{{ hotInfomationVol319 }}</div>
                  <div class="caret-circle-right">
                    <div class="overlap-group">
                      <img
                        class="vector"
                        :src="vector74"
                        alt="Vector"
                      />
                    </div>
                    <img class="vector-3" :src="vector3" alt="Vector" />
                  </div>
                </div>
              </div>
              <div class="frame-13213174">
                <div class="frame-13 news-item-clickable" @click="goToNewsDetail(1)">
                  <div class="date valign-text-middle inter-normal-sonic-silver-18px">{{ date2 }}</div>
                  <div :class="getCategoryClass(dynamicNewsItems[1])" class="category-badge">{{ getCategoryLabel(dynamicNewsItems[1]) }}</div>
                  <div class="text-58 valign-text-middle inter-normal-ship-gray-18px">{{ text123 }}</div>
                  <div class="caret-circle-right-1">
                    <div class="overlap-group">
                      <img
                        class="vector"
                        src="/img/vector-74.svg"
                        alt="Vector"
                      />
                    </div>
                    <img class="vector-4" :src="vector5" alt="Vector" />
                  </div>
                </div>
              </div>
              <div class="frame-13213174">
                <div class="frame-13 news-item-clickable" @click="goToNewsDetail(2)">
                  <div class="date valign-text-middle inter-normal-sonic-silver-18px">{{ date3 }}</div>
                  <div :class="getCategoryClass(dynamicNewsItems[2])" class="category-badge">{{ getCategoryLabel(dynamicNewsItems[2]) }}</div>
                  <div class="hot-info valign-text-middle inter-normal-ship-gray-18px">{{ hotInformationVol318 }}</div>
                  <div class="caret-circle-right">
                    <div class="overlap-group">
                      <img
                        class="vector"
                        src="/img/vector-74.svg"
                        alt="Vector"
                      />
                    </div>
                    <img class="vector-5" :src="vector8" alt="Vector" />
                  </div>
                </div>
              </div>
              <div class="frame-13213174">
                <div class="frame-13 news-item-clickable" @click="goToNewsDetail(3)">
                  <div class="date valign-text-middle inter-normal-sonic-silver-18px">{{ date4 }}</div>
                  <div :class="getCategoryClass(dynamicNewsItems[3])" class="category-badge">{{ getCategoryLabel(dynamicNewsItems[3]) }}</div>
                  <div class="hot-info valign-text-middle inter-normal-ship-gray-18px">{{ hotInformationVol3161 }}</div>
                  <div class="caret-circle-right">
                    <div class="overlap-group">
                      <img
                        class="vector"
                        src="/img/vector-74.svg"
                        alt="Vector"
                      />
                    </div>
                    <img class="vector-7" :src="vector10" alt="Vector" />
                  </div>
                </div>
              </div>
              <div class="frame-13213174">
                <div class="frame-13 news-item-clickable" @click="goToNewsDetail(4)">
                  <div class="date valign-text-middle inter-normal-sonic-silver-18px">{{ date5 }}</div>
                  <div :class="getCategoryClass(dynamicNewsItems[4])" class="category-badge">{{ getCategoryLabel(dynamicNewsItems[4]) }}</div>
                  <div class="hot-info valign-text-middle inter-normal-ship-gray-18px">{{ hotInformationVol3162 }}</div>
                  <div class="caret-circle-right">
                    <div class="overlap-group">
                      <img
                        class="vector"
                        src="/img/vector-74.svg"
                        alt="Vector"
                      />
                    </div>
                    <img class="vector-8" :src="vector12" alt="Vector" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Contact CTA Section -->
        <ContactSection />
        
        <div class="frame-1321317484">
        <div class="content-view">
          <div class="group-25">
            <div class="group-10-1">
              <div class="group-20">
                <img
                  class="vector-6"
                  :src="vector6"
                  alt="Vector 6"
                />
                <div class="text-36 valign-text-middle inter-bold-black-24px">{{ text101 }}</div>
              </div>
              <div class="ation valign-text-middle inter-bold-black-48px">{{ publications2 }}</div>
            </div>
          </div>
          <div class="frame-1321317472">
            <div class="main-publication-wrapper" @click="goToMainPublication">
              <frame1321317474 :x22="dynamicMainPublication.x22" />
            </div>
            <div class="frame-1321317485">
              <div class="frame-1321317487">
                <div class="group-18">
                  <img
                    class="vector-9"
                    :src="vector91"
                    alt="Vector 9"
                  />
                  <img
                    class="vector-10"
                    :src="vector101"
                    alt="Vector 10"
                  />
                </div>
                <x-button3 />
              </div>
              <div class="frame-1321317486">
                <div class="publication-item-wrapper" @click="goToPublication(0)">
                  <frame1321317475
                    :x22="dynamicPublications[0] ? dynamicPublications[0].x22 : frame13213174751Props.x22"
                    :hotInformationVol324="dynamicPublications[0] ? dynamicPublications[0].hotInformationVol324 : frame13213174751Props.hotInformationVol324"
                  />
                </div>
                <div class="publication-item-wrapper" @click="goToPublication(1)">
                  <frame1321317475
                    :x22="dynamicPublications[1] ? dynamicPublications[1].x22 : frame13213174752Props.x22"
                    :hotInformationVol324="dynamicPublications[1] ? dynamicPublications[1].hotInformationVol324 : frame13213174752Props.hotInformationVol324"
                  />
                </div>
                <div class="publication-item-wrapper" @click="goToPublication(2)">
                  <frame1321317475
                    :x22="dynamicPublications[2] ? dynamicPublications[2].x22 : frame13213174752Props.x22"
                    :hotInformationVol324="dynamicPublications[2] ? dynamicPublications[2].hotInformationVol324 : frame13213174752Props.hotInformationVol324"
                  />
                </div>
                <div class="publication-item-wrapper" @click="goToPublication(3)">
                  <frame1321317475
                    :x22="dynamicPublications[3] ? dynamicPublications[3].x22 : frame13213174752Props.x22"
                    :hotInformationVol324="dynamicPublications[3] ? dynamicPublications[3].hotInformationVol324 : frame13213174752Props.hotInformationVol324"
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="frame-21">
            <div class="vector-container">
              <img
                class="vector-11"
                :src="vector111"
                alt="Vector 11"
              />
              <img
                class="vector-13-1"
                :src="vector132"
                alt="Vector 13"
              />
              <img
                class="vector-12"
                :src="vector121"
                alt="Vector 12"
              />
            </div>
          </div>
        </div>
        <div class="content-view">
          <div class="group-25-1">
            <div class="group-10-2">
              <div class="group-20-1">
                <img
                  class="vector-6"
                  src="/img/vector-6.svg"
                  alt="Vector 6"
                />
                <div class="text-39 valign-text-middle inter-bold-black-24px">{{ text104 }}</div>
              </div>
              <div class="ation valign-text-middle inter-bold-black-48px">{{ otherInfomation }}</div>
            </div>
          </div>
          <div class="content-view-1">
            <frame1321317474 :x22="frame13213174742Props.x22" :className="frame13213174742Props.className" />
            <div class="frame-1321317473">
              <div class="frame-1321317473-1">
                <div class="overlap-group-container">
                  <div class="overlap-group3-1">
                    <img class="x2-2-1" :src="x222" alt="2 2" />
                    <div class="overlap-group2">
                      <div class="flex-col-2">
                        <div class="text-4 valign-text-middle inter-semi-bold-ship-gray-12px">{{ text108 }}</div>
                        <div class="viwe-more valign-text-middle inter-normal-ship-gray-10px">{{ viweMore2 }}</div>
                      </div>
                      <div class="caret-right">
                        <img
                          class="vector-14"
                          :src="vector65"
                          alt="Vector"
                        />
                        <img class="vector-17" :src="vector17" alt="Vector" />
                      </div>
                    </div>
                  </div>
                  <div class="overlap-group-1">
                    <img class="x2-3" :src="x23" alt="2 3" />
                    <div class="overlap-group-2">
                      <div class="flex-col">
                        <div class="text-4 valign-text-middle inter-semi-bold-ship-gray-12px">{{ text106 }}</div>
                        <div class="viwe-more valign-text-middle inter-normal-ship-gray-10px">{{ viweMore3 }}</div>
                      </div>
                      <div class="caret-right">
                        <img
                          class="vector-1"
                          :src="vector61"
                          alt="Vector"
                        />
                        <img class="vector-18" :src="vector19" alt="Vector" />
                      </div>
                    </div>
                  </div>
                  <div class="overlap-group-1">
                    <img class="x2-4" :src="x24" alt="2 4" />
                    <div class="overlap-group-2">
                      <div class="flex-col">
                        <div class="text-4 valign-text-middle inter-semi-bold-ship-gray-12px">{{ text107 }}</div>
                        <div class="viwe-more valign-text-middle inter-normal-ship-gray-10px">{{ viweMore4 }}</div>
                      </div>
                      <div class="caret-right">
                        <img
                          class="vector-1"
                          src="/img/vector-61.svg"
                          alt="Vector"
                        />
                        <img class="vector-19" :src="vector21" alt="Vector" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
      <svg class="vector-14-1" viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M1440 0.0001297L1440 75.3924C1026.71 219.527 754.524 -42.1312 3.89972e-06 75.3923L1.04907e-05 8.77342e-05L1440 0.0001297Z" fill="#ECECEC"/>
      </svg>
      
      <!-- Access Section -->
      <AccessSection />
      
      <!-- Partner Companies Section -->
      <div class="content-view-3">
        <div class="frame-1321317457-1">
          <img class="image-1" :src="image2" alt="image" /><img class="image-2" :src="image3" alt="image" /><img
            class="image-3"
            :src="image4"
            alt="image"
          /><img class="image-4" :src="image5" alt="image" />
        </div>
        <img
          class="vector-5-1"
          :src="vector5"
          alt="Vector 5"
        />
      </div>
      
      <!-- Footer Navigation -->
      <div class="navigation-footer">
        <Footer v-bind="frame132131753022Props" />
        <div class="vector-7-1"></div>
        <group27 />
      </div>
      
      <!-- Fixed Side Buttons -->
      <FixedSideButtons position="bottom" />
    </div>
</template>

<script>
import Navigation from "./Navigation";
import ContactSection from "./ContactSection.vue";
import Card from "./Card";
import Frame1321317481 from "./Frame1321317481";
import Frame13213176122 from "./Frame13213176122";
import XButton3 from "./XButton3";
import XButton4 from "./XButton4";
import Frame1321317474 from "./Frame1321317474";
import Frame1321317475 from "./Frame1321317475";
import Group10 from "./Group10";
import Footer from "./Footer";
import Group27 from "./Group27";
import AccessSection from "./AccessSection.vue";
import FixedSideButtons from "./FixedSideButtons.vue";
import { homePageData } from "../data.js";
import mockServer from "@/mockServer";
import apiClient from "@/services/apiClient"; // apiClientをインポート
import vector35 from "../../public/img/vector-35.svg";
import vector152 from "../../public/img/vector-15-2.svg";
import vector63 from "../../public/img/vector-6-3.svg";
import vector74 from "../../public/img/vector-74.svg";
import vector6 from "../../public/img/vector-6.svg";
import vector91 from "../../public/img/vector-9-1.svg";
import vector101 from "../../public/img/vector-10-1.svg";
import vector111 from "../../public/img/vector-11-1.svg";
import vector132 from "../../public/img/vector-13-2.svg";
import vector121 from "../../public/img/vector-12-1.svg";
import vector65 from "../../public/img/vector-65.svg";
import vector61 from "../../public/img/vector-61.svg";
import vector5 from "../../public/img/vector-5.svg";
import vector7 from "../../public/img/vector-7.svg";
export default {
  name: "HomePage",
  components: {
    Navigation,
    ContactSection,
    Card,
    Frame1321317481,
    Frame13213176122,
    XButton3,
    XButton4,
    Frame1321317474,
    Frame1321317475,
    Group10,
    Footer,
    Group27,
    AccessSection,
    FixedSideButtons,
  },
  data() {
    return {
      // Import data from homePageData
      heroImage: homePageData.heroImage,
      text66: homePageData.text66,
      text67: homePageData.text67,
      text68: homePageData.text68,
      frame13213174901: homePageData.frame13213174901,
      text72: homePageData.text72,
      seminar: homePageData.seminar,
      frame1321317491: homePageData.frame1321317491,
      text69: homePageData.text69,
      publications1: homePageData.publications1,
      frame13213174902: homePageData.frame13213174902,
      text70: homePageData.text70,
      infomation1: homePageData.infomation1,
      frame1321317492: homePageData.frame1321317492,
      text71: homePageData.text71,
      membership: homePageData.membership,
      text112: homePageData.text112,
      forYou: homePageData.forYou,
      text113: homePageData.text113,
      image1: homePageData.image1,
      text120: homePageData.text120,
      infomation2: homePageData.infomation2,
      text121: homePageData.text121,
      date1: homePageData.date1,
      hotInfomationVol319: homePageData.hotInfomationVol319,
      vector3: homePageData.vector3,
      date2: homePageData.date2,
      text123: homePageData.text123,
      date3: homePageData.date3,
      hotInformationVol318: homePageData.hotInformationVol318,
      vector8: homePageData.vector8,
      date4: homePageData.date4,
      hotInformationVol3161: homePageData.hotInformationVol3161,
      vector10: homePageData.vector10,
      date5: homePageData.date5,
      hotInformationVol3162: homePageData.hotInformationVol3162,
      vector12: homePageData.vector12,
      text101: homePageData.text101,
      publications2: homePageData.publications2,
      x221: homePageData.x221,
      date6: homePageData.date6,
      viweMore1: homePageData.viweMore1,
      hotInformationVol324: homePageData.hotInformationVol324,
      text104: homePageData.text104,
      otherInfomation: homePageData.otherInfomation,
      x222: homePageData.x222,
      text108: homePageData.text108,
      viweMore2: homePageData.viweMore2,
      vector17: homePageData.vector17,
      x23: homePageData.x23,
      text106: homePageData.text106,
      viweMore3: homePageData.viweMore3,
      vector19: homePageData.vector19,
      x24: homePageData.x24,
      text107: homePageData.text107,
      viweMore4: homePageData.viweMore4,
      vector21: homePageData.vector21,


      image2: homePageData.image2,
      image3: homePageData.image3,
      image4: homePageData.image4,
      image5: homePageData.image5,
      card1Props: homePageData.card1Props,
      card2Props: homePageData.card2Props,
      frame1321317481Props: homePageData.frame1321317481Props,
      frame13213174741Props: homePageData.frame13213174741Props,
      frame13213174751Props: homePageData.frame13213174751Props,
      frame13213174752Props: homePageData.frame13213174752Props,
      frame13213174742Props: homePageData.frame13213174742Props,
      frame132131753022Props: homePageData.frame132131753022Props,
      // Dynamic CMS data for publications
      dynamicMainPublication: homePageData.frame13213174741Props, // デフォルト値
      dynamicPublications: [], // CMSから取得した刊行物データ
      allPublications: [], // 全ての刊行物データ（ID参照用）
      // Dynamic news data
      dynamicNewsItems: [], // CMSから取得したニュースデータ（カテゴリー情報含む）
      // Vector images for UI elements
      vector35,
      vector152,
      vector63,
      vector74,
      vector6,
      vector91,
      vector101,
      vector111,
      vector132,
      vector121,
      vector65,
      vector61,
      vector5,
      vector7,
    };
  },
  async mounted() {
    // CMSから最新データを取得
    await this.loadLatestData();
  },
  methods: {
    async loadLatestData() {
      try {
        // MockServerが有効な場合はそれを使用する（開発時など）
        if (mockServer.isEnabled()) {
            console.log("Fetching data from MockServer...");
            const allNews = await mockServer.getAllNews();
            const seminars = await mockServer.getSeminars();
            const publications = await mockServer.getPublications();
            const notices = await mockServer.getNotices();
            this.updatePageData(allNews, seminars, publications, notices);
            return;
        }

        console.log("Fetching data from API...");
        // APIからデータを取得
        const [newsResponse, seminarsResponse, publicationsResponse, noticesResponse] = await Promise.all([
          apiClient.getNews({ per_page: 5 }), // 最新5件
          apiClient.getSeminars(),
          apiClient.getPublications(),
          apiClient.getNotices()
        ]);

        const allNews = newsResponse.data || [];
        const seminars = seminarsResponse.data || [];
        const publications = publicationsResponse.data || [];
        const notices = noticesResponse.data || [];

        this.updatePageData(allNews, seminars, publications, notices);

      } catch (error) {
        console.error('CMSデータの取得に失敗:', error);
        // エラー時は何もしない（デフォルトデータが既に表示されているため）
      }
    },

    updatePageData(allNews, seminars, publications, notices) {
      // 最新の5件を取得
      const latestNews = allNews.slice(0, 5);
      this.dynamicNewsItems = latestNews; // ニュースデータを保存
      
      // 既存のデータ変数に最新情報をマッピング
      if (latestNews.length > 0) {
        // 1件目
        const news1 = latestNews[0];
        this.date1 = this.formatDate(news1.date);
        this.hotInfomationVol319 = news1.title;
        
        // 2件目
        if (latestNews[1]) {
          const news2 = latestNews[1];
          this.date2 = this.formatDate(news2.date);
          this.text123 = news2.title;
        }
        
        // 3件目
        if (latestNews[2]) {
          const news3 = latestNews[2];
          this.date3 = this.formatDate(news3.date);
          this.hotInformationVol318 = news3.title;
        }
        
        // 4件目
        if (latestNews[3]) {
          const news4 = latestNews[3];
          this.date4 = this.formatDate(news4.date);
          this.hotInformationVol3161 = news4.title;
        }
        
        // 5件目
        if (latestNews[4]) {
          const news5 = latestNews[4];
          this.date5 = this.formatDate(news5.date);
          this.hotInformationVol3162 = news5.title;
        }
      }
      
      // 最新のセミナー数を更新
      const upcomingSeminars = seminars.filter(s => s.status === 'ongoing' || s.status === 'scheduled');
      if (upcomingSeminars.length > 0) {
        this.seminar = `セミナー(${upcomingSeminars.length}件)`;
      }
      
      // 最新の刊行物数を更新
      if (publications.length > 0) {
        this.publications1 = `刊行物(${publications.length}件)`;
        this.allPublications = publications; // 全データを保存
        
        // メイン刊行物（最新）のデータを設定
        const mainPublication = publications[0];
        if (mainPublication) {
          this.dynamicMainPublication = {
            x22: mainPublication.image_url || this.frame13213174741Props.x22 // デフォルト画像を使用
          };
        }
        
        // 右側の刊行物リスト（最大4件）用のデータを設定
        const defaultImages = [
          this.frame13213174751Props.x22, // 1番目のデフォルト画像
          this.frame13213174752Props.x22, // 2番目のデフォルト画像  
          this.frame13213174752Props.x22, // 3番目のデフォルト画像
          this.frame13213174752Props.x22  // 4番目のデフォルト画像
        ];
        
        this.dynamicPublications = publications.slice(0, 4).map((pub, index) => ({
          x22: pub.image_url || defaultImages[index], // CMSの画像がなければデフォルト画像
          hotInformationVol324: pub.title
        }));
      }
      
      // お知らせ数を更新
      const importantNotices = notices.filter(n => n.isImportant);
      if (notices.length > 0) {
        this.infomation1 = `お知らせ(${importantNotices.length > 0 ? importantNotices.length : notices.length}件)`;
      }
    },
    formatDate(dateString) {
      const date = new Date(dateString);
      const year = date.getFullYear();
      const month = date.getMonth() + 1;
      const day = date.getDate();
      return `${year}.${String(month).padStart(2, '0')}.${String(day).padStart(2, '0')}`;
    },
    goToMainPublication() {
      // メイン刊行物（最新）の詳細ページに遷移
      if (this.allPublications.length > 0) {
        const mainPublication = this.allPublications[0];
        this.$router.push(`/publications/${mainPublication.id}`);
      }
    },
    goToPublication(index) {
      // 指定されたインデックスの刊行物詳細ページに遷移
      if (this.allPublications.length > index) {
        const publication = this.allPublications[index];
        this.$router.push(`/publications/${publication.id}`);
      }
    },
    getCategoryLabel(newsItem) {
      // ニュースの種類に応じてカテゴリーラベルを返す
      if (!newsItem) return 'NEWS';
      
      switch (newsItem.type) {
        case 'seminar':
          return 'SEMINAR';
        case 'publication':
          return 'PUBLICATION';
        case 'notice':
          return 'NEWS';
        default:
          return 'NEWS';
      }
    },
    getCategoryClass(newsItem) {
      // ニュースの種類に応じてCSSクラスを返す
      if (!newsItem) return 'news-category';
      
      switch (newsItem.type) {
        case 'seminar':
          return 'seminar-category';
        case 'publication':
          return 'publication-category';
        case 'notice':
          return 'news-category';
        default:
          return 'news-category';
      }
    },
    goToNewsDetail(index) {
      // 指定されたインデックスのニュース詳細ページに遷移
      if (this.dynamicNewsItems.length > index && this.dynamicNewsItems[index]) {
        const newsItem = this.dynamicNewsItems[index];
        this.$router.push(`/news/${newsItem.id}`);
      }
    }
  }
};
</script>

<style scoped>
.home-page {
  background: #ffffff;
  min-height: 100vh;
  width: 100%;
}

/* Hero Section */
.hero-section {
  width: 100%;
  height: 900px;
  padding: 50px;
  position: relative;
  box-sizing: border-box;
}

.hero-image {
  background-position: 50% 50%;
  background-size: cover;
  border-radius: 20px;
  height: 100%;
  width: 100%;
  position: relative;
  overflow: hidden;
}

.hero-overlay {
  background-color: rgba(77, 77, 77, 0.2);
  border-radius: 10px;
  height: 100%;
  width: 100%;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  align-items: flex-start;
  padding: 170px 70px;
}

.hero-content {
  display: flex;
  flex-direction: column;
  gap: 20px;
  width: 100%;
  max-width: 911px;
}

.hero-title-wrapper {
  align-items: center;
  background-color: var(--white);
  border-radius: 15px;
  display: inline-flex;
  gap: 10px;
  justify-content: flex-start;
  padding: 15px 25px;
  width: fit-content;
}

.hero-title {
  font-family: var(--font-family-inter);
  font-size: 48px;
  font-weight: 700;
  color: var(--black);
  letter-spacing: 0;
  line-height: normal;
  margin: 0;
}

.hero-subtitle-wrapper {
  align-items: center;
  background-color: var(--white);
  border-radius: 15px;
  display: inline-flex;
  gap: 10px;
  justify-content: flex-start;
  overflow: hidden;
  padding: 15px 25px;
  width: fit-content;
}

.hero-subtitle {
  font-family: var(--font-family-inter);
  font-size: 48px;
  font-weight: 700;
  color: var(--black);
  letter-spacing: 0;
  line-height: normal;
  margin: 0;
}

.hero-button-wrapper {
  align-items: center;
  background-color: var(--mandy);
  border-radius: 10px;
  display: inline-flex;
  gap: 20px;
  justify-content: flex-start;
  overflow: hidden;
  padding: 15px 25px;
  width: fit-content;
}

.hero-button-text {
  font-family: var(--font-family-inter);
  font-size: 20px;
  font-weight: 700;
  color: var(--white);
  letter-spacing: 0;
  line-height: normal;
  margin: 0;
}

.hero-button-icon {
  background-color: var(--white);
  border-radius: 8px;
  height: 27px;
  width: 27px;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}

.vector-2 {
  height: 12px;
  width: 14px;
}

.frame-1321317611 {
  align-items: center;
  background-color: var(--mandy);
  border-radius: 10px;
  display: inline-flex;
  flex: 0 0 auto;
  gap: 20px;
  justify-content: center;
  overflow: hidden;
  padding: 15px 25px;
  position: relative;
}

.text-3-1 {
  letter-spacing: 0;
  line-height: normal;
  position: relative;
  white-space: nowrap;
  width: fit-content;
}

.frame-1321317612 {
  background-color: var(--white);
  border-radius: 8px;
  height: 27px;
  overflow: hidden;
  position: relative;
  width: 27px;
}

.vector-2 {
  height: 12px;
  left: 6px;
  position: absolute;
  top: 8px;
  width: 14px;
}

.frame-1321317457 {
  align-items: flex-end;
  background-color: var(--white);
  border-radius: 10px;
  display: flex;
  height: auto;
  overflow: hidden;
  padding: 20px;
  width: 80%;
  max-width: 100vw;
  margin: -94px auto 0;
  position: relative; /* z-indexが効く */
  z-index: 2; /* overlap-group7 より上 */
  gap: 20px;
  box-sizing: border-box;
}

.vector-13 {
  height: 120px;
  margin-top: 50px;
  width: 100vw;
  min-width: 100vw;
  max-width: 100vw;
  position: relative;
  left: 50%;
  transform: translateX(-50%);
  object-fit: fill;
  object-position: center;
  box-sizing: border-box;
}

.frame-1321317490 {
  align-items: flex-start;
  background-position: 50% 50%;
  background-size: cover;
  border-radius: 10px;
  display: flex;
  overflow: hidden;
  width: calc(25% - 15px);
  flex-shrink: 0;
  aspect-ratio: 284 / 148;
}

.frame-1321317491 {
  align-items: flex-end;
  background-color: var(--abbey);
  display: flex;
  flex-direction: column;
  height: 100%;
  justify-content: center;
  padding: 0px 70px;
  position: relative;
  width: 100%;
}

.text-1 {
  align-self: stretch;
  letter-spacing: -0.3px;
  line-height: 60px;
  position: relative;
  text-align: center;
}

.seminar,
.publications,
.infomation {
  align-self: stretch;
  letter-spacing: -0.48px;
  line-height: 60px;
  margin-top: -30px;
  position: relative;
  text-align: center;
}

.frame-1321317491-1 {
  align-items: flex-start;
  background-position: 50% 50%;
  background-size: cover;
  border-radius: 10px;
  display: flex;
  overflow: hidden;
  width: calc(25% - 15px);
  flex-shrink: 0;
  aspect-ratio: 284 / 148;
}

.frame-1321317491-2 {
  align-items: center;
  background-color: var(--abbey);
  display: flex;
  flex-direction: column;
  height: 100%;
  justify-content: center;
  padding: 0px 27px;
  position: relative;
  width: 100%;
}

.frame-1321317490-1 {
  align-items: flex-start;
  background-position: 50% 50%;
  background-size: cover;
  border-radius: 10px;
  display: flex;
  overflow: hidden;
  width: calc(25% - 15px);
  flex-shrink: 0;
  aspect-ratio: 283 / 148;
}

.frame-1321317491-3 {
  align-items: center;
  background-color: var(--abbey);
  display: flex;
  flex-direction: column;
  height: 100%;
  justify-content: center;
  padding: 0px 42px;
  position: relative;
  width: 100%;
}

.text-2 {
  align-self: stretch;
  letter-spacing: -0.32px;
  line-height: 60px;
  position: relative;
  text-align: center;
}

.frame-1321317492 {
  align-items: flex-start;
  background-position: 50% 50%;
  background-size: cover;
  border-radius: 10px;
  display: flex;
  overflow: hidden;
  width: calc(25% - 15px);
  flex-shrink: 0;
  aspect-ratio: 284 / 148;
}

.frame-1321317491-4 {
  align-items: center;
  background-color: var(--abbey);
  display: flex;
  flex-direction: column;
  height: 100%;
  justify-content: center;
  padding: 0px 70px;
  position: relative;
  width: 100%;
}

.membership {
  letter-spacing: -0.48px;
  line-height: 60px;
  margin-left: -6.5px;
  margin-right: -6.5px;
  margin-top: -30px;
  position: relative;
  text-align: center;
  white-space: nowrap;
  width: fit-content;
}



.overlap-group8 {
  height: auto;
  position: relative;
  width: 100%;
  max-width: 100vw;
  z-index: 6;
  box-sizing: border-box;
}

.main {
  align-items: center;
  background-color: var(--cararra);
  display: flex;
  flex-direction: column;
  gap: 50px;
  padding: 0px 50px 50px;
  position: relative;
  width: 100%;
}

.about {
  align-self: center;
  height: auto;
  position: relative;
  width: 100%;
  max-width: 1340px;
}

.flex-col-1 {
  align-items: center;
  display: flex;
  flex-direction: column;
  width: 100%;
  height: auto;
}

.ico_logo-2 {
  height: 35px;
  position: relative;
  width: 100%;
  max-width: 1340px;
}

.text-47 {
  color: var(--hot-pink);
  font-family: var(--font-family-inter);
  font-size: 36px;
  font-weight: 600;
  letter-spacing: -0.72px;
  line-height: normal;
  margin-top: 31px;
  min-height: 44px;
  text-align: center;
  width: 100%;
  max-width: 1340px;
}

.group-30 {
  align-items: center;
  display: flex;
  margin-left: 2px;
  margin-top: 33px;
  min-width: 270px;
}

.vector-16 {
  height: 2px;
  width: 69px;
}

.for-you {
  color: var(--hot-pink);
  font-family: var(--font-family-inter);
  font-size: var(--font-size-xl);
  font-weight: 700;
  height: 30px;
  letter-spacing: 0;
  line-height: 30px;
  margin-left: 21px;
  min-width: 89px;
  white-space: nowrap;
}

.vector-15 {
  height: 2px;
  margin-left: 20px;
  width: 69px;
}

.text-48 {
  color: var(--ship-gray);
  font-family: var(--font-family-inter);
  font-size: var(--font-size-xl);
  font-weight: 400;
  letter-spacing: -0.4px;
  line-height: 40px;
  margin-top: 25px;
  min-height: 80px;
  text-align: center;
  width: 100%;
  max-width: 1340px;
}

.frame-1321317462 {
  align-items: center;
  align-self: center;
  display: flex;
  flex-direction: column;
  gap: 10px;
  position: relative;
  width: 100%;
  max-width: 100%;
  overflow: hidden;
}

.frame-1321317456 {
  align-items: center;
  display: flex;
  flex-direction: column;
  gap: 40px;
  position: relative;
  width: 100%;
  max-width: 2000px;
  box-sizing: border-box;
}

.frame-1321317482 {
  display: flex;
  gap: 20px;
  overflow: hidden;
  position: relative;
  width: 100%;
  justify-content: center;
  align-items: flex-start;
  box-sizing: border-box;
}


.card {
  position: relative;
  width: calc((100% - 40px) / 3);
  flex-shrink: 0;
  aspect-ratio: 434 / 330;
}

.image {
  align-items: flex-end;
  background-position: 50% 50%;
  background-size: cover;
  border-radius: 10px;
  display: flex;
  height: 100%;
  overflow: hidden;
  position: relative;
  width: 100%;
}

.button {
  align-items: center;
  background-color: #1A1A1A;
  border-radius: 10px;
  box-shadow: 0px 1px 2px #0000000d;
  display: flex;
  gap: 10px;
  justify-content: center;
  padding: 10px 50px;
  position: relative;
  min-width: 200px;
  max-width: 100%;
  box-sizing: border-box;
}

.text-55 {
  letter-spacing: 0;
  line-height: 22.5px;
  margin-top: -1px;
  position: relative;
  white-space: nowrap;
  width: fit-content;
}

.content-view {
  align-items: flex-start;
  align-self: center;
  background-color: var(--white);
  border-radius: 20px;
  display: flex;
  flex: 0 0 auto;
  flex-direction: column;
  gap: 30px;
  overflow: hidden;
  padding: 50px;
  position: relative;
  width: 100%;
  max-width: 2000px;
}

.frame-1321317480 {
  align-items: center;
  align-self: stretch;
  display: flex;
  flex: 0 0 auto;
  justify-content: space-between;
  position: relative;
  width: 100%;
}

.group-10 {
  height: 120px;
  position: relative;
  width: 313px;
}

.infomation-1 {
  height: 72px;
  left: 0;
  letter-spacing: 0;
  line-height: 72px;
  position: absolute;
  top: 48px;
  white-space: nowrap;
}

.flex-row {
  align-items: center;
  display: flex;
  gap: 23px;
  height: 36px;
  left: 0;
  min-width: 209px;
  position: absolute;
  top: 0;
}

.vector-6 {
  height: 1px;
  object-fit: cover;
  width: 91px;
}

.text-56 {
  height: 36px;
  letter-spacing: 0;
  line-height: 36px;
  min-width: 95px;
  white-space: nowrap;
}

.frame-1321317467 {
  align-items: flex-start;
  align-self: stretch;
  display: flex;
  flex: 0 0 auto;
  flex-direction: column;
  position: relative;
  width: 100%;
}

.frame-13213174 {
  align-self: stretch;
  height: 80px;
  position: relative;
  width: 100%;
}

.frame-13 {
  align-items: center;
  border-bottom: 0.5px dashed;
  border-bottom-width: 1px;
  border-color: var(--mandy);
  display: flex;
  height: 79px;
  position: relative;
  top: 1px;
  width: 100%;
  max-width: 100%;
}

.date {
  height: 13px;
  letter-spacing: 0;
  line-height: 36px;
  margin-bottom: 2px;
  min-width: 93px;
  white-space: nowrap;
}

.hot-info {
  height: 13px;
  letter-spacing: 0;
  line-height: 36px;
  margin-bottom: 2px;
  margin-left: 20px;
  min-width: 200px;
  white-space: nowrap;
  flex: 1;
}

.caret-circle-right {
  align-items: flex-start;
  display: flex;
  overflow: hidden;
  width: 33px;
  position: absolute;
  right: 0;
  top: 50%;
  transform: translateY(-50%);
}

.overlap-group {
  align-items: center;
  align-self: center;
  background-image: url(/img/vector-73.svg);
  background-size: 100% 100%;
  display: flex;
  height: 27px;
  justify-content: flex-end;
  margin-left: 3px;
  min-width: 27px;
  padding: 0 9.3px;
}

.vector {
  height: 12px;
  width: 7px;
}

.vector-3 {
  height: 33px;
  margin-top: -2103px;
  width: 33px;
}

.text-58 {
  height: 13px;
  letter-spacing: 0;
  line-height: 36px;
  margin-bottom: 2px;
  margin-left: 20px;
  min-width: 200px;
  white-space: nowrap;
  flex: 1;
}

.caret-circle-right-1 {
  align-items: flex-start;
  display: flex;
  overflow: hidden;
  width: 33px;
  position: absolute;
  right: 0;
  top: 50%;
  transform: translateY(-50%);
}

.vector-4 {
  height: 33px;
  margin-top: -2183px;
  width: 33px;
}

.vector-5 {
  height: 33px;
  margin-top: -2263px;
  width: 33px;
}

.vector-7 {
  height: 33px;
  margin-top: -2343px;
  width: 33px;
}

.vector-8 {
  height: 33px;
  margin-top: -2423px;
  width: 33px;
}

.frame-1321317484 {
  display: flex;
  flex-direction: column; /* 縦に並べる */
  align-items: flex-start; /* 左寄せ */
  gap: 50px;               /* 要素間のスペース */
  background-color: var(--cararra);
  padding: 50px;
  width: 100%;             /* 親に合わせる */
  z-index: 5;              /* 他要素と重なる場合だけ */
}


.group-25 {
  height: 126px;
  position: relative;
  width: 356px;
}

.group-10-1 {
  align-items: flex-start;
  display: flex;
  flex-direction: column;
  gap: 18px;
  min-height: 126px;
  width: 358px;
}

.group-20 {
  align-items: center;
  display: flex;
  gap: 26px;
  min-width: 191px;
}

.text-36 {
  height: 36px;
  letter-spacing: 0;
  line-height: 36px;
  min-width: 72px;
  white-space: nowrap;
}

.ation {
  height: 72px;
  letter-spacing: 0;
  line-height: 72px;
  white-space: nowrap;
}

.frame-1321317472 {
  align-items: flex-end;
  align-self: stretch;
  display: flex;
  flex: 0 0 auto;
  gap: 20px;
  position: relative;
  width: 100%;
}

.frame-1321317485 {
  align-items: flex-start;
  align-self: stretch;
  background-color: var(--white);
  display: flex;
  flex-direction: column;
  gap: 20px;
  justify-content: flex-end;
  overflow: hidden;
  position: relative;
  flex: 1;
}

.frame-1321317487 {
  align-items: flex-end;
  align-self: stretch;
  background-color: var(--white);
  display: flex;
  height: 91px;
  justify-content: space-between;
  position: relative;
  width: 100%;
}

.group-18 {
  height: 43px;
  position: relative;
  width: 88px;
}

.vector-9 {
  height: 43px;
  left: 0;
  position: absolute;
  top: 0;
  width: 23px;
}

.vector-10 {
  height: 43px;
  left: 65px;
  position: absolute;
  top: 0;
  width: 24px;
}

.frame-1321317486 {
  align-items: center;
  background-color: var(--white);
  display: inline-flex;
  flex: 0 0 auto;
  gap: 20px;
  margin-right: -183px;
  position: relative;
}

.frame-1321317475 {
  height: 286px;
  overflow: hidden;
  position: relative;
  width: 259px;
}

.overlap-group3 {
  height: 286px;
  position: relative;
  width: 265px;
}

.x2-2 {
  height: 252px;
  left: 0;
  object-fit: cover;
  position: absolute;
  top: 0;
  width: 76px;
}

.overlap-group-3 {
  height: 69px;
  left: 49px;
  position: absolute;
  top: 217px;
  width: 158px;
}

.rectangle-6 {
  height: 69px;
  left: 0;
  position: absolute;
  top: 0;
  width: 27px;
}

.date-1 {
  height: 15px;
  left: 8px;
  letter-spacing: 0;
  line-height: 15px;
  position: absolute;
  top: 5px;
  width: 58px;
}

.viwe-more-1 {
  height: 12px;
  left: 8px;
  letter-spacing: 0;
  line-height: 12px;
  position: absolute;
  text-decoration: underline;
  top: 49px;
  white-space: nowrap;
}

.hot-information-vol324 {
  height: 17px;
  left: 8px;
  letter-spacing: 0;
  line-height: 16.5px;
  position: absolute;
  top: 20px;
  width: 150px;
}

.frame-21 {
  height: 1px;
  margin-bottom: -1px;
  position: relative;
  width: 100%;
  max-width: 1239px;
}

.vector-container {
  align-items: flex-start;
  display: flex;
  width: 100%;
  overflow: hidden;
}

.vector-11 {
  height: 1px;
  object-fit: cover;
  width: 48.7%;
  max-width: 603px;
}

.vector-13-1 {
  height: 1px;
  object-fit: cover;
  width: 14.8%;
  max-width: 184px;
}

.vector-12 {
  height: 1px;
  object-fit: cover;
  width: 36.5%;
  max-width: 452px;
}

.group-25-1 {
  height: 126px;
  position: relative;
  width: 485px;
}

.group-10-2 {
  align-items: flex-start;
  display: flex;
  flex-direction: column;
  gap: 18px;
  min-height: 126px;
  width: 487px;
}

.group-20-1 {
  align-items: center;
  display: flex;
  gap: 26px;
  min-width: 263px;
}

.text-39 {
  height: 36px;
  letter-spacing: 0;
  line-height: 36px;
  min-width: 144px;
  white-space: nowrap;
}

.content-view-1 {
  height: 398px;
  position: relative;
  width: 100%;
}

.frame-1321317473 {
  align-items: flex-start;
  display: flex;
  flex-direction: column;
  gap: 10px;
  left: 609px;
  position: absolute;
  top: 0;
  width: calc(100% - 609px);
}

.frame-1321317473-1 {
  align-self: stretch;
  height: 398px;
  overflow: hidden;
  position: relative;
  width: 100%;
}

.overlap-group-container {
  align-items: flex-start;
  display: flex;
  flex-direction: column;
  gap: 15px;
  position: relative;
  top: 1px;
  width: 100%;
}

.overlap-group3-1 {
  height: 122px;
  position: relative;
  width: 100%;
}

.x2-2-1,
.x2-3,
.x2-4 {
  height: 122px;
  left: 0;
  object-fit: cover;
  position: absolute;
  top: 0;
  width: 100%;
  min-width: 100%;
  max-width: 100%;
}

.overlap-group2 {
  align-items: center;
  background-color: var(--white);
  border-radius: 10px 0px 0px 0px;
  display: flex;
  gap: 41px;
  height: 60px;
  justify-content: flex-end;
  right: 0;
  min-width: 309px;
  padding: 1.3px 12.7px;
  position: absolute;
  bottom: 0;
}

.flex-col-2 {
  align-items: flex-start;
  align-self: flex-end;
  display: flex;
  flex-direction: column;
  gap: 7px;
  min-height: 41px;
  width: 220px;
}

.text-4 {
  height: 13px;
  letter-spacing: 0;
  line-height: 18px;
  white-space: nowrap;
}

.viwe-more {
  height: 16px;
  letter-spacing: 0;
  line-height: 15px;
  text-decoration: underline;
  white-space: nowrap;
}

.caret-right {
  align-items: flex-start;
  display: flex;
  gap: 957px;
  margin-bottom: 0.96px;
  overflow: hidden;
  width: 17px;
}

.vector-14 {
  align-self: center;
  height: 13px;
  margin-left: 5px;
  margin-top: 0;
  width: 7px;
}

.vector-17 {
  height: 17px;
  margin-top: -4002.07px;
  width: 17px;
}

.overlap-group-1 {
  height: 123px;
  position: relative;
  width: 100%;
}

.overlap-group-2 {
  align-items: center;
  background-color: var(--white);
  border-radius: 10px 0px 0px 0px;
  display: flex;
  gap: 42px;
  height: 60px;
  justify-content: flex-end;
  right: 0;
  min-width: 314px;
  padding: 1.3px 13px;
  position: absolute;
  bottom: 0;
}

.flex-col {
  align-items: flex-start;
  align-self: flex-end;
  display: flex;
  flex-direction: column;
  gap: 7px;
  min-height: 41px;
  width: 224px;
}

.vector-1 {
  align-self: center;
  height: 13px;
  margin-left: 5px;
  width: 7px;
}

.vector-18 {
  height: 17px;
  margin-top: -4140px;
  width: 17px;
}

.vector-19 {
  height: 17px;
  margin-top: -4278px;
  width: 17px;
}

.vector-14-1 {
  height: 120px;
  width: 100vw;
  min-width: 100vw;
  max-width: 100vw;
  position: relative;
  left: 50%;
  transform: translateX(-50%);
  z-index: 8;
  box-sizing: border-box;
}





.content-view-3 {
  align-items: center;
  background-color: var(--celeste);
  display: flex;
  flex-direction: column;
  gap: 50px;
  margin-right: -1px;
  padding: 50px;
  position: relative;
  width: 100%;
  max-width: 100vw;
  z-index: 2;
  box-sizing: border-box;
}

.frame-1321317457-1 {
  align-items: center;
  align-self: center;
  display: flex;
  flex: 0 0 auto;
  gap: 22px;
  position: relative;
  width: 100%;
  max-width: 2000px;
  justify-content: center;
  box-sizing: border-box;
}

.image-1 {
  height: auto;
  object-fit: cover;
  position: relative;
  width: calc((100% - 66px) / 4);
  aspect-ratio: 318 / 118;
}

.image-2 {
  height: auto;
  object-fit: cover;
  position: relative;
  width: calc((100% - 66px) / 4);
  aspect-ratio: 319 / 96;
}

.image-3 {
  height: auto;
  object-fit: cover;
  position: relative;
  width: calc((100% - 66px) / 4);
  aspect-ratio: 319 / 129;
}

.image-4 {
  height: auto;
  object-fit: cover;
  position: relative;
  width: calc((100% - 66px) / 4);
  aspect-ratio: 318 / 129;
}

.vector-5-1 {
  height: 1px;
  margin-bottom: -0.5px;
  object-fit: cover;
  position: relative;
  width: 1240px;
}

.navigation-footer {
  align-items: center;
  background-color: var(--celeste);
  display: flex;
  flex-direction: column;
  gap: 50px;
  padding: 100px;
  position: relative;
  width: 100%;
  max-width: 100vw;
  z-index: 4;
  box-sizing: border-box;
}

.vector-7-1 {
  height: 1px;
  background-color: #B2B2B2;
  position: relative;
  width: 100%;
  max-width: 1240px;
}

/* Responsive Design */
@media (max-width: 1700px) {
  .content-view {
    max-width: 100%;
    padding: 50px 30px;
  }
  
  .main {
    padding: 0px 30px 50px;
    width: 100%;
    max-width: 100vw;
    box-sizing: border-box;
  }
  
  .about {
    max-width: 100%;
  }
  
  .text-47,
  .text-48 {
    width: 100%;
    max-width: 100%;
  }
  
  .hot-info,
  .text-58 {
    min-width: 150px;
    flex: 1;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  
  .frame-1321317608 {
    width: 100%;
    max-width: 100%;
  }
  
  .frame-1321317482 {
    gap: 15px;
  }
  
  .card {
    width: calc((100% - 30px) / 3);
  }
}

@media (max-width: 900px) {
  .u12488u12483u12501u12442-1 {
    overflow-x: auto;
  }
  
  .hero-section,
  .main,
  .content-view,
  .content-view-3,
  .navigation-footer,
  .frame-1321317457,
  .overlap-group7,
  .overlap-group8 {
    min-width: 900px;
  }
}



@media (max-width: 768px) {
  .hero-section {
    min-height: 300px;
    height: 40vh;
  }
  
  .hero-overlay {
    padding: 30px 20px;
  }
  
  .main {
    padding: 0px 20px 50px;
    width: 100%;
    max-width: 100vw;
    box-sizing: border-box;
  }
  
  .frame-1321317482 {
    flex-direction: column;
    gap: 15px;
  }
  
  .card {
    width: 100%;
    max-width: 400px;
  }
  
  .frame-1321317457-1 {
    flex-wrap: wrap;
    gap: 15px;
  }
  
  .image-1,
  .image-2,
  .image-3,
  .image-4 {
    width: calc(50% - 7.5px);
    height: auto;
  }
  

}

@media (max-width: 768px) {
  .hero-section {
    height: 600px;
    padding: 30px 20px;
  }
  
  .hero-overlay {
    padding: 100px 40px;
  }
  
  .hero-title,
  .hero-subtitle {
    font-size: 32px;
  }
  
  .hero-button-text {
    font-size: 16px;
  }
}

@media (max-width: 480px) {
  .hero-section {
    height: 500px;
    padding: 20px 15px;
  }
  
  .hero-overlay {
    padding: 80px 30px;
  }
  
  .hero-title,
  .hero-subtitle {
    font-size: 24px;
  }
  
  .hero-button-wrapper {
    padding: 12px 20px;
  }
  
  .hero-button-text {
    font-size: 14px;
  }
  
  .main {
    padding: 0px 30px 50px;
  }
  
  .content-view,
  .content-view-3 {
    padding: 0px 30px 50px;
  }
  
  .frame-1321317457-1 {
    gap: 10px;
  }
  
  .image-1,
  .image-2,
  .image-3,
  .image-4 {
    width: 100%;
    height: auto;
  }
}

/* クリック可能な刊行物アイテムのスタイル */
.main-publication-wrapper,
.publication-item-wrapper {
  cursor: pointer;
  transition: transform 0.2s ease, opacity 0.2s ease;
}

.main-publication-wrapper:hover,
.publication-item-wrapper:hover {
  transform: scale(1.02);
  opacity: 0.9;
}

/* 動的カテゴリーバッジのスタイル */
.category-badge {
  background-color: #da5761;
  color: white;
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 12px;
  font-weight: 600;
  text-align: center;
  white-space: nowrap;
  margin-left: 20px;
  margin-right: 20px;
  min-width: 60px;
  display: inline-block;
}

.news-category {
  background-color: #da5761;
}

.seminar-category {
  background-color: #28a745;
}

.publication-category {
  background-color: #007bff;
}

/* クリック可能なニュース項目のスタイル */
.news-item-clickable {
  cursor: pointer;
  transition: background-color 0.2s ease, transform 0.1s ease;
}

.news-item-clickable:hover {
  background-color: rgba(218, 87, 97, 0.05);
  transform: translateX(5px);
}

.news-item-clickable:active {
  transform: translateX(3px);
}
</style>


