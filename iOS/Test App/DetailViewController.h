//
//  DetailViewController.h
//  Test App
//
//  Created by James Guthrie on 26/03/2014.
//  Copyright (c) 2014 Hey Jimmy Ltd. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface DetailViewController : UIViewController <UISplitViewControllerDelegate>

@property (strong, nonatomic) id detailItem;

@property (weak, nonatomic) IBOutlet UILabel *detailDescriptionLabel;
@end
