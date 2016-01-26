

# Spark Installation Guide


## Requirements

In order to install Spark, you need to install dig-workflows, dig-entity-merger and Web-Karma first.
Open a shell(command prompt) and use git clone commands to get these 3 project.

```
	git clone https://github.com/usc-isi-i2/dig-workflows.git
	git clone https://github.com/usc-isi-i2/dig-entity-merger.git
	git clone https://github.com/usc-isi-i2/Web-Karma.git
```

## Install dig-entity-merger

Go to dig-entity-merger file, use ls command to see if make-spark.sh is inside, if it is, run this file.

```
	cd dig-entity-merger
	./make-spark.sh
```

## Install Karma

Karma is written in JAVA and will run on Mac, Linux and Windows. To Install Web Karma, you will need Java 1.7 and Maven 3.0.

Java 1.7
Download from http://www.oracle.com/technetwork/java/javase/downloads/index.html
Make sure JAVA_HOME environment variable is pointing to JDK 1.7

Maven 3.0
Make sure that M2_HOME and M2 environment variables are set as described in Maven Installation Instructions: http://maven.apache.org/download.cgi
	 When system requirements are satisfied, run the following commands:

```
	cd Web-Karma
	git checkout pyspark-compatiblity
	mvn clean install –DskipTests
```


“BUILD SUCCESS” indicates build successfully. Then type:


```
	cd karma-spark
	mvn install –Pshaded
```

“BUILD SUCCESS” indicates build successfully. Then type:

```
	cd target
	ls
```


Go to find the karma-spark-0.0.1-SNAPSHOT-shaded.jar file and write down the absolute path of this file. For example,
…… /Web-Karma/karma-spark/target/karma-spark-0.0.1-SNAPSHOT-shaded.jar


## Go to the file where you put dig-entity-merger, and find the file merger.zip, write down the absolute path of merger.zip. For example, …… /dig-entity-merger/digEntityMerger/merger.zip

```
	cd dig-entity-merger
	cd digEntityMerger
	ls
```
  
  
## Install Spark

Go to the website to download Spark, choose  Spark release: 1.3.0(Mar 13 2015); package type: Pre-built for Hadoop 2.4 and later; download type: direct Download.[https://spark.apache.org/releases/spark-release-1-3-0.html]
  
When you download spark-1.3.0-bin-hadoop2.4.tgz, type these commands to unzip this file and edit system PATH variable:

```
	unzip spark-1.3.0-bin-hadoop2.4.tgz
	cd spark-1.3.0-bin-hadoop2.4
	cd bin
	pwd
```

After typing pwd command, you will get the current path and add this path to PATH variable. For example,

```
	export PATH=…… /spark-1.3.0-bin-hadoop2.4/bin:$PATH
On the command prompt, type:
	cd ..
	spark-submit
```

You will see “Spark assembly has been built with Hive, including Datanucleus jars on classpath”.

## Test with an example

Go to the file where you put dig-workflows, then go to the file pySpark-workflows. You will find the file adsWorkflow.py.


```
	cd dig-workflows
	cd pySpark-workflows
```


On the command prompt, type:


```
 rm -rf karma-out; spark-submit \
       --master local[1] \
       --archives karma.zip \
       --py-files javaToPythonSpark.py \
       --py-files [path to merger.zip] \
       --driver-class-path [path to karma-spark-0.0.1-SNAPSHOT-shaded.jar] \
       adsWorkflow.py \
       part-00002 text 1 \
       ads-hair-eye-sample text 1 \
       karma-out
```

You need to substitute the path to merger.zip and path to karma-spark-0.0.1-SNAPSHOT-shaded.jar with the paths you just wrote down. Meanwhile, “part-00002” and “ads-hair-eye-sample” are 2 input files and “karma-out” is the output file name.
After the command is typed and ran successfully, you can see the results in the file karma-out.





