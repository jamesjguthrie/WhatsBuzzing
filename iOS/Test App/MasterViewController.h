//
//  MasterViewController.h
//  Test App
//
//  Created by James Guthrie on 26/03/2014.
//  Copyright (c) 2014 Hey Jimmy Ltd. All rights reserved.
//

#import <UIKit/UIKit.h>

@class DetailViewController;

@interface MasterViewController : UITableViewController

@property (strong, nonatomic) DetailViewController *detailViewController;

@end
