# -*- coding: utf-8 -*-
"""
Created on Sun Nov  3 09:40:47 2019
@author: Arunava Dey,Amiya Ghosh,Dipanjan Maity,Anick Bhattacharya
"""
from datetime import datetime
import mysql.connector
import pandas as pd
import statsmodels.api as sm
import matplotlib.pyplot as plt
import seaborn as sns
import numpy as np
from sqlalchemy import create_engine
sns.set()
mydb=mysql.connector.connect(
    host='localhost',
    user="root",passwd="",
    database="bengalathon"
    )

mycursor=mydb.cursor()

sql=pd.read_sql_query('SELECT * FROM water_usage_train',mydb)

raw_data = pd.DataFrame(sql)
# We make sure to create a copy of the data before we start altering it. Note that we don't change the original data we loaded.
data = raw_data.copy()

# Removes the index column that came with the data
#data = data.drop(['sensorId','Area','Day','Month','Year'], axis = 1)
#print(data)
# We use the map function to change any 'yes' values to 1 and 'no' values to 0. 
data['Excess_use_or_not'] = data['Excess_use_or_not'].map({'yes':1, 'no':0})
y = data['Excess_use_or_not']
x1 = data['wusage']
x = sm.add_constant(x1)
reg_log = sm.Logit(y,x)
results_log = reg_log.fit()
#plt.scatter(x1,y,color = 'C0')
# Creating a logit function, depending on the input and coefficients
def f(x,b0,b1):
    return np.array(np.exp(b0+x*b1) / (1 + np.exp(b0+x*b1)))
# Sorting the y and x, so we can plot the curve
f_sorted = np.sort(f(x1,results_log.params[0],results_log.params[1]))
x_sorted = np.sort(np.array(x1))
#plt.scatter(x1,y,color='C0')
#plt.xlabel('Daily_Water_usage', fontsize = 20)
#plt.ylabel('Excess_use_or_not', fontsize = 20)
# Plotting the curve
#plt.plot(x_sorted,f_sorted,color='C8')
#plt.show()
#print(results_log.summary())
cm_df = pd.DataFrame(results_log.pred_table())
cm_df.columns = ['Predicted 0','Predicted 1']
cm_df = cm_df.rename(index={0: 'Actual 0',1:'Actual 1'})
#print(cm_df)
# Create an array (so it is easier to calculate the accuracy)
cm = np.array(cm_df)
# Calculate the accuracy of the model
accuracy_train = (cm[0,0]+cm[1,1])/cm.sum()
#print("Training Accuracy of model:",accuracy_train," ")
'''
test_raw=pd.read_csv('Documents\water_avg_test.csv')
test = test_raw.drop(['Unnamed: 0'], axis = 1)
test['Excess use or not'] = test['Excess use or not'].map({'yes':1, 'no':0})
#print(test.head())
test_actual=test['Excess use or not']
test_data=test.drop(['Excess use or not'],axis=1)
test_data= sm.add_constant(test_data)
#print(test_data.head())
print("Testing the Model")
def confusion_matrix(data,actual_values,model):
    pred_values=model.predict(data)
    df_excess=test_raw[pred_values==1]
    df_excess=df_excess.drop(['Unnamed: 0'],axis=1)
    df_excess.to_csv('Documents\Excess_users.csv',index=False)
    bins=np.array([0,0.5,1])
    cm=np.histogram2d(actual_values,pred_values,bins=bins)[0]
    cm_df = pd.DataFrame(cm)
    cm_df.columns = ['Predicted 0','Predicted 1']
    cm_df = cm_df.rename(index={0: 'Actual 0',1:'Actual 1'})
    print(cm_df)
    test_accuracy=(cm[0,0]+cm[1,1])/cm.sum()
    print("Test Accuracy of model:",test_accuracy)
    return
confusion_matrix(test_data,test_actual,results_log)
'''
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
