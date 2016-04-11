#! /usr/bin/python

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

__author__="Jacob"
__date__ ="$Apr 9, 2016 11:56:14 PM$"

def parseRRule(txRRule):
    if(txRRule != ""):
        rules = txRRule.split(";")
        RRule = {}
        for rule in rules:
            if(rule != ""):
                keyval = rule.split("=")
                if(keyval[1].isdigit()):
                    RRule[keyval[0]] = int(keyval[1])
                else:
                    RRule[keyval[0]] = keyval[1]
        return RRule
    else:
        return txRRule

def strptime(string, format):
    from datetime import datetime
    format = "%Y-%m-%dT" + format
    return datetime.strptime("2016-01-01T"+string, format).time()

def index(list, search):
    index = 0
    for item in list:
        if (item == search):
            return index
        index+=1
    return -1

def is_number(test):
    try:
        float(test)
        return True
    except ValueError:
        return False
