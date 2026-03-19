//
//  ViewController.h
//  crudemC
//
//  Created by Filipe Jacobson Marra on 28/08/24.
//

#import <UIKit/UIKit.h>

@interface ViewController : UIViewController <UITableViewDataSource, UITableViewDelegate>

@property (nonatomic, strong) NSMutableArray *contacts;
@property (nonatomic, strong) UITableView *tableView;

@end


