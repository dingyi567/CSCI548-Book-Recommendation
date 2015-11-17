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
        dict1 = {}
        try:
            dict1["BookURL"] = response.url
        except IndexError:
            dict1["BookURL"] = ""
        self.log("-----------BookURL %s" % dict1["BookURL"])


        h = response.xpath('//img[@id="imgBlkFront"]//@src').extract()   
        try:
            dict1["ImageURL"] = h[0]  
        except IndexError:
            dict1["ImageURL"] = ""
        self.log("-----------ImageURL %s" % dict1["ImageURL"])


        f = response.xpath('//span[@id="productTitle"]/text()').extract()
        try:
            dict1["BookTitle"] = f[0]
        except IndexError:
            dict1["BookTitle"] = ""
        self.log("-----------BookTitle %s" % dict1["BookTitle"])


        g =  response.xpath('//div[@id="byline"]//span[@class="author notFaded"]//span[@class="a-declarative"]//a[contains(@class, "a-link-normal")]//text()').extract()      
        try:
            dict1["AuthorName"] = g[0]
        except IndexError:
            g =  response.xpath('//div[@id="byline"]//span[@class="author notFaded"]//a[contains(@class, "a-link-normal")]//text()').extract()      
            dict1["AuthorName"] = g[0]
        self.log("-----------AuthorName %s" % dict1["AuthorName"] )


        k =  response.xpath('//div[@id="booksTitle"]//span[@class="author notFaded"]//a[contains(@class, "a-link-normal")]//@href').extract()  
        try:
            dict1["AuthorLink"] = self.allowed_domains[0] + k[0]
        except IndexError:
            dict1["AuthorLink"] = ""       
        self.log("-----------AuthorLink %s" % dict1["AuthorLink"] )


        a = response.xpath('//div[@id="detail-bullets"]//table[@id="productDetailsTable"]//ul//li[contains(., "Publisher")]//text()').extract()
        try:
            dict1["Publisher"] = a[1]
        except IndexError:
            dict1["Publisher"] = ""
        self.log("-----------Publisher %s" % dict1["Publisher"] )


        b  = response.xpath('//div[@id="detail-bullets"]//table[@id="productDetailsTable"]//ul//li[contains(., "Paperback")]//text()').extract()
        try:      
            dict1["Paperback"] = b[1]
        except IndexError:
            dict1["Paperback"] = ""
        self.log("-----------Paperback %s" % dict1["Paperback"] )


        c = response.xpath('//div[@id="detail-bullets"]//table[@id="productDetailsTable"]//ul//li[contains(., "Language")]//text()').extract()
        try:        
            dict1["Language"] = c[1]
        except IndexError:
            dict1["Language"] = ""
        self.log("-----------Language %s" % dict1["Language"] )


        d = response.xpath('//div[@id="detail-bullets"]//table[@id="productDetailsTable"]//ul//li[contains(., "ISBN-10")]//text()').extract()
        try:       
            dict1["ISBN-10"] = d[1]
        except IndexError:
            dict1["ISBN-10"] = ""
        self.log("-----------ISBN-10 %s" % dict1["ISBN-10"] )


        e = response.xpath('//div[@id="detail-bullets"]//table[@id="productDetailsTable"]//ul//li[contains(., "ISBN-13")]//text()').extract()
        try:
            dict1["ISBN-13"] = e[1]
        except IndexError:
            dict1["ISBN-13"] = ""
        self.log("-----------ISBN-13 %s" % dict1["ISBN-13"] )


        i = response.xpath('//div[@id="bookDescription_feature_div"]//noscript//node()').extract()
        try:
            dict1["Description"] = i[1]
        except IndexError:
            dict1["Description"] = ""
        self.log("-----------Description %s" % dict1["Description"] )

#recommend links
        recommendList = []
        for x in range(1,6):
            recommendItem = {}
            #s1 = '//li[@class="a-carousel-card a-float-left"][%d]//div//a//@href' %x
            #recommendItem["URL"] = self.allowed_domains[0] + response.xpath(s1).extract()[0]
            try:
                s1 = '//li[@class="a-carousel-card a-float-left"][%d]/div/a/@href' %x
                recommendItem["URL"] = self.allowed_domains[0] + response.xpath(s1).extract()[0]
            except IndexError:
                recommendItem["URL"] = ""

            #s2 = '//li[@class="a-carousel-card a-float-left"]//div//a//div[@class="a-section a-spacing-mini"]//image//@src'
            s2 = '//li[@class="a-carousel-card a-float-left"][%d]/div/a/div[1]/img/@src' %x
            recommendItem["coverImage"] = response.xpath(s2).extract() 

            #s3 = '//li[@class="a-carousel-card a-float-left"][%d]//div//a//div[@class="p13n-sc-truncated"]/text()' %x
            s3 = '//li[@class="a-carousel-card a-float-left"][%d]/div/a/div[2]/text()' %x
            recommendItem["title"] = response.xpath(s3).extract() 

            s4 = '//li[@class="a-carousel-card a-float-left"][%d]//div[@class="a-row a-size-small"]//a//text()' %x
            recommendItem["authorName"] = response.xpath(s4).extract() 
           
            try:
                s5 = '//li[@class="a-carousel-card a-float-left"][%d]//div[@class="a-row a-size-small"]//a//@href' %x
                recommendItem["authorLink"] = self.allowed_domains[0] + response.xpath(s5).extract()[0]
            except IndexError:
                recommendItem["authorLink"] = ""


            recommendList.append(recommendItem)

        dict1["recommend"] = recommendList
        self.log("-----------recommend %s" % dict1["recommend"] )



        with open('resultTemp.json','a+') as output:
            output.write(json.dumps(dict1) + '\n')



