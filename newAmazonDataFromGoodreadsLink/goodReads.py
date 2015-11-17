import scrapy
import json
from scrapy.spiders import Spider
from scrapy.selector import Selector
from scrapy.selector import HtmlXPathSelector
from scrapy.http import HtmlResponse

class AmazonSpider(scrapy.Spider):
    name = "amazon2"
    allowed_domains = ["www.amazon.com", "www.goodreads.com"]
    start_urls = []
    f_open = open("goodreadsurl", "r")
    for link in f_open:
        link = link.strip()
        start_urls.append(link)


    def parse(self,response):
        for link in self.start_urls:
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



        with open('resultOfGoodreadsLink.json','a+') as output:
            output.write(json.dumps(dict1) + '\n')




