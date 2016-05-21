#! /usr/bin/python

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

import pstats

p = pstats.Stats("profile")
p.sort_stats("cumtime").print_stats()