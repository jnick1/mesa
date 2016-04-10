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
