#! /usr/bin/python

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

__author__="Jacob"
__date__ ="$Apr 24, 2016 12:25:32 AM$"

import pstats

p = pstats.Stats("profile")
p.sort_stats("cumtime").print_stats()