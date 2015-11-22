import scrapy
import json
from scrapy.spiders import Spider
from scrapy.selector import Selector
from scrapy.selector import HtmlXPathSelector
from scrapy.http import HtmlResponse

class AmazonSpider(scrapy.Spider):
    name = "amazon1"
    allowed_domains = ["www.amazon.com"]
    base_urls = [
    #adventure
    "http://www.amazon.com/s/ref=sr_nr_n_0?fst=as%3Aoff&rh=n%3A283155%2Cn%3A%211000%2Cn%3A25%2Cp_n_feature_browse-bin%3A2656022011%2Cn%3A16272%2Cn%3A16273&bbn=16272&ie=UTF8&qid=1447229925&rnid=16272",
    #alienInvasion
    "http://www.amazon.com/gp/search/ref=sr_nr_n_1?fst=as%3Aoff&rh=n%3A283155%2Cn%3A%211000%2Cn%3A25%2Cp_n_feature_browse-bin%3A2656022011%2Cn%3A16272%2Cn%3A9059886011&bbn=16272&ie=UTF8&qid=1447229925&rnid=16272",
    #alternate history
    "http://www.amazon.com/s/ref=sr_nr_n_2?fst=as%3Aoff&rh=n%3A283155%2Cn%3A%211000%2Cn%3A25%2Cp_n_feature_browse-bin%3A2656022011%2Cn%3A16272%2Cn%3A16275&bbn=16272&ie=UTF8&qid=1447230130&rnid=16272",
    #Antologies
    "http://www.amazon.com/s/ref=sr_nr_n_3?fst=as%3Aoff&rh=n%3A283155%2Cn%3A%211000%2Cn%3A25%2Cp_n_feature_browse-bin%3A2656022011%2Cn%3A16272%2Cn%3A16277&bbn=16272&ie=UTF8&qid=1447230195&rnid=16272",
    #Colonization
    "http://www.amazon.com/gp/search/ref=sr_nr_n_4?fst=as%3Aoff&rh=n%3A283155%2Cn%3A%211000%2Cn%3A25%2Cp_n_feature_browse-bin%3A2656022011%2Cn%3A16272%2Cn%3A10387335011&bbn=16272&ie=UTF8&qid=1447230195&rnid=16272",
    #Cyberpunk
    "http://www.amazon.com/s/ref=sr_nr_n_5?fst=as%3Aoff&rh=n%3A283155%2Cn%3A%211000%2Cn%3A25%2Cp_n_feature_browse-bin%3A2656022011%2Cn%3A16272%2Cn%3A9059887011&bbn=16272&ie=UTF8&qid=1447230130&rnid=16272",
    # Dystopian
    "http://www.amazon.com/s/ref=sr_nr_n_6?fst=as%3Aoff&rh=n%3A283155%2Cn%3A%211000%2Cn%3A25%2Cp_n_feature_browse-bin%3A2656022011%2Cn%3A16272%2Cn%3A3559311011&bbn=16272&ie=UTF8&qid=1447230130&rnid=16272",
    #exploration
    "http://www.amazon.com/s/ref=sr_nr_n_7?fst=as%3Aoff&rh=n%3A283155%2Cn%3A%211000%2Cn%3A25%2Cp_n_feature_browse-bin%3A2656022011%2Cn%3A16272%2Cn%3A10387340011&bbn=16272&ie=UTF8&qid=1447230130&rnid=16272",
    #First Contact
    "http://www.amazon.com/s/ref=sr_nr_n_8?fst=as%3Aoff&rh=n%3A283155%2Cn%3A%211000%2Cn%3A25%2Cp_n_feature_browse-bin%3A2656022011%2Cn%3A16272%2Cn%3A10387336011&bbn=16272&ie=UTF8&qid=1447230130&rnid=16272",
    #Galactic Empire
    "http://www.amazon.com/s/ref=sr_nr_n_9?fst=as%3Aoff&rh=n%3A283155%2Cn%3A%211000%2Cn%3A25%2Cp_n_feature_browse-bin%3A2656022011%2Cn%3A16272%2Cn%3A10387337011&bbn=16272&ie=UTF8&qid=1447230130&rnid=16272",
    #Genetic Engineering
    "http://www.amazon.com/s/ref=sr_nr_n_10?fst=as%3Aoff&rh=n%3A283155%2Cn%3A%211000%2Cn%3A25%2Cp_n_feature_browse-bin%3A2656022011%2Cn%3A16272%2Cn%3A9059888011&bbn=16272&ie=UTF8&qid=1447230130&rnid=16272",
    #Hard Science Fiction
    "http://www.amazon.com/s/ref=sr_nr_n_11?fst=as%3Aoff&rh=n%3A283155%2Cn%3A%211000%2Cn%3A25%2Cp_n_feature_browse-bin%3A2656022011%2Cn%3A16272%2Cn%3A16286&bbn=16272&ie=UTF8&qid=1447230130&rnid=16272",
    # History & Criticism
    "http://www.amazon.com/s/ref=sr_nr_n_12?fst=as%3Aoff&rh=n%3A283155%2Cn%3A%211000%2Cn%3A25%2Cp_n_feature_browse-bin%3A2656022011%2Cn%3A16272%2Cn%3A16288&bbn=16272&ie=UTF8&qid=1447230130&rnid=16272",
    #Military
    "http://www.amazon.com/s/ref=sr_nr_n_13?fst=as%3Aoff&rh=n%3A283155%2Cn%3A%211000%2Cn%3A25%2Cp_n_feature_browse-bin%3A2656022011%2Cn%3A16272%2Cn%3A7538385011&bbn=16272&ie=UTF8&qid=1447230130&rnid=16272",
    # Post-Apocalyptic
    "http://www.amazon.com/s/ref=sr_nr_n_14?fst=as%3Aoff&rh=n%3A283155%2Cn%3A%211000%2Cn%3A25%2Cp_n_feature_browse-bin%3A2656022011%2Cn%3A16272%2Cn%3A7538386011&bbn=16272&ie=UTF8&qid=1447230130&rnid=16272",
    #Short Stories
    "http://www.amazon.com/s/ref=sr_nr_n_15?fst=as%3Aoff&rh=n%3A283155%2Cn%3A%211000%2Cn%3A25%2Cp_n_feature_browse-bin%3A2656022011%2Cn%3A16272%2Cn%3A16308&bbn=16272&ie=UTF8&qid=1447230130&rnid=16272",
    #Space Opera
    "http://www.amazon.com/s/ref=sr_nr_n_16?fst=as%3Aoff&rh=n%3A283155%2Cn%3A%211000%2Cn%3A25%2Cp_n_feature_browse-bin%3A2656022011%2Cn%3A16272%2Cn%3A271585011&bbn=16272&ie=UTF8&qid=1447230130&rnid=16272",
    #Steampunk
    "http://www.amazon.com/s/ref=sr_nr_n_17?fst=as%3Aoff&rh=n%3A283155%2Cn%3A%211000%2Cn%3A25%2Cp_n_feature_browse-bin%3A2656022011%2Cn%3A16272%2Cn%3A3559312011&bbn=16272&ie=UTF8&qid=1447230130&rnid=16272",
    #Time Travel
    "http://www.amazon.com/s/ref=sr_nr_n_18?fst=as%3Aoff&rh=n%3A283155%2Cn%3A%211000%2Cn%3A25%2Cp_n_feature_browse-bin%3A2656022011%2Cn%3A16272%2Cn%3A7587452011&bbn=16272&ie=UTF8&qid=1447230130&rnid=16272"
    ]
    start_urls = []
    for base in base_urls:
        for i in range(1, 101):
            start_urls.append(base+ "&page=" + str(i))

    def parse(self,response):
        link_list = response.xpath('//ul[@id="s-results-list-atf"]//li//div//div//div//div[@class="a-fixed-left-grid-col a-col-right"]//div[@class="a-row a-spacing-small"]//a[contains(@class, "s-access-detail-page")]//@href').extract()
        for link in link_list:
            self.log("----------1 %s" % link)
            yield scrapy.Request(link, callback = self.scrape)

  
    def scrape(self,response):

        self.log("----------- %s" % response.url)
        with open('amazonLink','a+') as output:
            output.write(response.url + '\n')



