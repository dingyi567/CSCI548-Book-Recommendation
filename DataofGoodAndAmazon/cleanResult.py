f1 = open("resultOfGoodreadsAndAmazon.json", "r")
f2 = open("resultOfGoodreadsAndAmazon1.json", "w")

f2.write("[")
for line in f1.readlines():
	f2.write(line+",")

f2.write("]")
f1.close()
f2.close()