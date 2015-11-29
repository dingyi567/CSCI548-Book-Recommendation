import json


with open('goodreadsclean.json') as data_file:    
    data = json.load(data_file)

f_write = open("goodreadsurl", "a+")
allLinks = []

for book in data:
	link = book["authorlink"]
	if link not in allLinks:
		allLinks.append(link)
	

for i in allLinks:
	f_write.write(i+"\n")

f_write.close()




