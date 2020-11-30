# -*- coding: utf-8 -*-
"""
Created on Sun Nov  3 09:40:47 2019
@author: Arunava Dey,Amiya Ghosh,Dipanjan Maity,Anick Bhattacharya
"""
from datetime import datetime   #For using Date and time related functions
import mysql.connector			#For Connecting to mysql database and traversing
import pandas as pd 			#For Dataframe functions
import statsmodels.api as sm 	#This module provides the required ML framework (Logistic Regression)
import numpy as np 				#For Array conversions 
from sqlalchemy import create_engine  #This module supports the MySQL connector

mydb=mysql.connector.connect( 			#Connector object for MySQL database created
    host='localhost',
    user="root",passwd="",
    database="bengalathon"
    )

mycursor=mydb.cursor() 					#Cursor for traversing database created

sql=pd.read_sql_query('SELECT * FROM water_usage_train',mydb) 	#Converting sql table to pandas dataframe

raw_data = pd.DataFrame(sql)
# We make sure to create a copy of the data before we start altering it. Note that we don't change the original data we loaded.
data = raw_data.copy()

data['Excess_use_or_not'] = data['Excess_use_or_not'].map({'yes':1, 'no':0}) 	# Mapping to Numerical values for training on the dataset
y = data['Excess_use_or_not']
x1 = data['wusage']
x = sm.add_constant(x1)
reg_log = sm.Logit(y,x) 			# The model is trained using Logistic Regression Algorithm
results_log = reg_log.fit() 		#The trained model is made ready for future predictions

cm_df = pd.DataFrame(results_log.pred_table()) 		#Initializing the Confusion Matrix for the Trained Model
cm_df.columns = ['Predicted 0','Predicted 1']
cm_df = cm_df.rename(index={0: 'Actual 0',1:'Actual 1'})

# Create an array (so it is easier to calculate the accuracy)
cm = np.array(cm_df)
# Calculate the accuracy of the model
accuracy_train = (cm[0,0]+cm[1,1])/cm.sum()

#Reading Usage Table, predicting excess use or not and Updating the penalty/excess users table
sql=pd.read_sql_query('SELECT * FROM wsage WHERE month='+str(datetime.now().month),mydb)
pred=pd.DataFrame(sql)
pred_data = pred.drop(['area','sid','day','month','year'], axis = 1)
pred_data= sm.add_constant(pred_data)
pred_values=results_log.predict(pred_data)
df_excess=pred[pred_values==1]
engine = create_engine('mysql+mysqlconnector://root:@localhost/bengalathon')
df_excess.to_sql(name='penalty', con=engine, if_exists = 'replace', index=False)
print("Excess Users Table updated successfully")
mydb.close()
